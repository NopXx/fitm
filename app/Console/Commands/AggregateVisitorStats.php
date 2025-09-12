<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Services\IpInfoService;
use Carbon\Carbon;

class AggregateVisitorStats extends Command
{
    protected $signature = 'visitors:aggregate
        {--date= : Aggregate a specific date (YYYY-MM-DD)}
        {--from= : Aggregate from this date (YYYY-MM-DD)}
        {--to= : Aggregate to this date (YYYY-MM-DD, inclusive)}
        {--days= : Aggregate last N days (excludes today)}
        {--purge : Purge raw logs after aggregation}
        {--purge-before= : Purge logs created before this date (YYYY-MM-DD)}
        {--purge-days= : Purge logs older than N days from now}
        {--purge-range : Purge logs up to the last aggregated date}
        {--skip-regions : Skip region aggregation to avoid external lookups}';
    protected $description = 'Aggregate visitor logs into daily summaries (supports ranges) and optionally purge logs older than 30 days';

    public function handle(): int
    {
        $dates = [];
        $skipRegions = (bool)$this->option('skip-regions');

        if ($this->option('from') || $this->option('to')) {
            $from = $this->option('from') ? Carbon::parse($this->option('from'))->startOfDay() : Carbon::yesterday()->startOfDay();
            $to = $this->option('to') ? Carbon::parse($this->option('to'))->startOfDay() : Carbon::yesterday()->startOfDay();
            if ($to->lt($from)) {
                [$from, $to] = [$to, $from];
            }
            for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
                $dates[] = $d->copy();
            }
        } elseif ($this->option('days')) {
            $days = (int)$this->option('days');
            // Aggregate last N days excluding today
            for ($i = $days; $i >= 1; $i--) {
                $dates[] = Carbon::today()->subDays($i)->startOfDay();
            }
        } else {
            $dateOption = $this->option('date');
            $dates[] = $dateOption ? Carbon::parse($dateOption)->startOfDay() : Carbon::yesterday()->startOfDay();
        }

        foreach ($dates as $targetDate) {
            $this->aggregateForDate($targetDate, $skipRegions);
        }

        if ($this->option('purge')) {
            $cutoff = null;
            // 1) explicit purge-before takes highest priority
            if ($this->option('purge-before')) {
                $cutoff = Carbon::parse($this->option('purge-before'))->endOfDay();
            }
            // 2) purge-range uses the last aggregated date
            elseif ($this->option('purge-range') && !empty($dates)) {
                $last = end($dates);
                // ensure Carbon instance
                $last = $last instanceof Carbon ? $last : Carbon::parse((string) $last);
                $cutoff = $last->copy()->endOfDay();
            }
            // 3) purge-days (relative to now)
            elseif ($this->option('purge-days')) {
                $n = max(0, (int) $this->option('purge-days'));
                $cutoff = Carbon::now()->subDays($n);
            }
            // 4) default keep-last-30-days policy
            else {
                $cutoff = Carbon::now()->subDays(30);
            }

            $deleted = DB::table('visitor_logs')->where('created_at', '<', $cutoff)->delete();
            $this->info("Purged $deleted logs older than " . $cutoff->toDateString());
        }

        return self::SUCCESS;
    }

    private function aggregateForDate(Carbon $targetDate, bool $skipRegions = false): void
    {
        $start = $targetDate->copy();
        $end = $targetDate->copy()->endOfDay();

        $this->info('Aggregating for date: ' . $targetDate->toDateString());

        // Exclude admin/api/login/lang pages (same rules used elsewhere)
        $applyPublicPagesFilter = function ($query) {
            $query->where(function ($q) {
                $q->where('page', '!=', 'admin')
                    ->where('page', '!=', 'login')
                    ->where('page', 'not like', 'admin/%')
                    ->where('page', 'not like', 'api/%')
                    ->where('page', 'not like', 'lang/%');
            })->orWhereNull('page');
        };

        // Quick check to avoid heavy work if no logs on that date
        $exists = DB::table('visitor_logs')
            ->whereBetween('created_at', [$start, $end])
            ->where($applyPublicPagesFilter)
            ->limit(1)
            ->exists();

        if (!$exists) {
            // still ensure a zero row for totals to keep continuity if needed
            DB::table('visitor_daily_totals')->upsert([
                [
                    'date' => $targetDate->toDateString(),
                    'unique_visitors' => 0,
                    'pageviews' => 0,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            ], ['date'], ['unique_visitors', 'pageviews', 'updated_at']);
            $this->info('No logs found for ' . $targetDate->toDateString() . ', inserted zero summary.');
            return;
        }

        // Totals
        $totals = DB::table('visitor_logs')
            ->selectRaw('COUNT(DISTINCT ip_address) as unique_visitors, COUNT(*) as pageviews')
            ->whereBetween('created_at', [$start, $end])
            ->where($applyPublicPagesFilter)
            ->first();

        DB::table('visitor_daily_totals')->upsert([
            [
                'date' => $targetDate->toDateString(),
                'unique_visitors' => (int)($totals->unique_visitors ?? 0),
                'pageviews' => (int)($totals->pageviews ?? 0),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ], ['date'], ['unique_visitors', 'pageviews', 'updated_at']);

        // Pages
        $pages = DB::table('visitor_logs')
            ->selectRaw("COALESCE(page, '') as page, COUNT(*) as visits")
            ->whereBetween('created_at', [$start, $end])
            ->where($applyPublicPagesFilter)
            ->groupBy('page')
            ->get();

        $pageRows = [];
        foreach ($pages as $row) {
            $pageRows[] = [
                'date' => $targetDate->toDateString(),
                'page' => $row->page ?? '',
                'visits' => (int)$row->visits,
                'updated_at' => now(),
                'created_at' => now(),
            ];
        }
        if (!empty($pageRows)) {
            DB::table('visitor_daily_pages')->upsert($pageRows, ['date', 'page'], ['visits', 'updated_at']);
        }

        if ($skipRegions) {
            $this->info('Skipping region aggregation.');
            return;
        }

        // Regions (derive from unique IPs for the day using IpInfoService)
        $ipQuery = DB::table('visitor_logs')
            ->select('ip_address')
            ->whereBetween('created_at', [$start, $end])
            ->where($applyPublicPagesFilter)
            ->distinct();

        $ips = $ipQuery->pluck('ip_address');

        $regionCounts = [];
        $ipInfo = app(IpInfoService::class);
        $maxLookups = (int) (config('services.ipinfo.max_lookups', 100));
        $lookups = 0;
        foreach ($ips as $ip) {
            if ($lookups >= $maxLookups) {
                $regionCounts['Unknown'] = ($regionCounts['Unknown'] ?? 0) + 1;
                continue;
            }
            $data = $ipInfo->getLocationData($ip);
            $region = $data['region'] ?? 'Unknown';
            $regionCounts[$region] = ($regionCounts[$region] ?? 0) + 1;
            $lookups++;
        }

        if (!empty($regionCounts)) {
            $regionRows = [];
            foreach ($regionCounts as $region => $count) {
                $regionRows[] = [
                    'date' => $targetDate->toDateString(),
                    'region' => $region ?: 'Unknown',
                    'count' => (int)$count,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];
            }
            DB::table('visitor_daily_regions')->upsert($regionRows, ['date', 'region'], ['count', 'updated_at']);
        }

        $this->info('Aggregation completed for ' . $targetDate->toDateString());
    }
}
