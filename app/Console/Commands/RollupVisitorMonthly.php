<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RollupVisitorMonthly extends Command
{
    protected $signature = 'visitors:rollup-monthly
        {--month= : Rollup a specific month (YYYY-MM)}
        {--from= : Rollup from this month (YYYY-MM)}
        {--to= : Rollup to this month (YYYY-MM, inclusive)}
        {--purge-daily : Purge daily tables after rollup}
        {--purge-daily-before= : Purge daily where date <= end of this month (YYYY-MM)}
        {--purge-daily-range : Purge daily up to the last month processed}';

    protected $description = 'Aggregate daily summaries into monthly tables and optionally purge old daily rows';

    public function handle(): int
    {
        $months = [];

        if ($this->option('from') || $this->option('to')) {
            $from = $this->parseMonth($this->option('from') ?? Carbon::now()->format('Y-m'));
            $to = $this->parseMonth($this->option('to') ?? Carbon::now()->format('Y-m'));
            if ($to->lt($from)) [$from, $to] = [$to, $from];
            for ($m = $from->copy(); $m->lte($to); $m->addMonth()) {
                $months[] = $m->copy();
            }
        } else {
            $monthOption = $this->option('month');
            $months[] = $this->parseMonth($monthOption ?? Carbon::now()->subMonth()->format('Y-m'));
        }

        foreach ($months as $month) {
            $this->rollupForMonth($month);
        }

        if ($this->option('purge-daily')) {
            $this->purgeOldDaily($months);
        }

        return self::SUCCESS;
    }

    private function parseMonth(string $ym): Carbon
    {
        return Carbon::createFromFormat('Y-m', $ym)->startOfMonth();
    }

    private function rollupForMonth(Carbon $month): void
    {
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();
        $monthKey = $start->toDateString();

        $this->info('Rolling up month: ' . $start->format('Y-m'));

        // Totals
        $totals = DB::table('visitor_daily_totals')
            ->selectRaw('SUM(unique_visitors) as uv, SUM(pageviews) as pv')
            ->whereBetween('date', [$start, $end])
            ->first();

        DB::table('visitor_monthly_totals')->upsert([
            [
                'month' => $monthKey,
                'unique_visitors' => (int)($totals->uv ?? 0),
                'pageviews' => (int)($totals->pv ?? 0),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        ], ['month'], ['unique_visitors', 'pageviews', 'updated_at']);

        // Pages
        $pages = DB::table('visitor_daily_pages')
            ->selectRaw('page, SUM(visits) as visits')
            ->whereBetween('date', [$start, $end])
            ->groupBy('page')
            ->get();

        if ($pages->count() > 0) {
            $rows = [];
            foreach ($pages as $row) {
                $rows[] = [
                    'month' => $monthKey,
                    'page' => $row->page ?? '',
                    'visits' => (int)$row->visits,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];
            }
            DB::table('visitor_monthly_pages')->upsert($rows, ['month', 'page'], ['visits', 'updated_at']);
        }

        // Regions
        $regions = DB::table('visitor_daily_regions')
            ->selectRaw('region, SUM(`count`) as c')
            ->whereBetween('date', [$start, $end])
            ->groupBy('region')
            ->get();

        if ($regions->count() > 0) {
            $rows = [];
            foreach ($regions as $row) {
                $rows[] = [
                    'month' => $monthKey,
                    'region' => $row->region ?? 'Unknown',
                    'count' => (int)$row->c,
                    'updated_at' => now(),
                    'created_at' => now(),
                ];
            }
            DB::table('visitor_monthly_regions')->upsert($rows, ['month', 'region'], ['count', 'updated_at']);
        }

        $this->info('Rollup done for ' . $start->format('Y-m'));
    }

    private function purgeOldDaily(array $processedMonths = []): void
    {
        // If user provided a cutoff month explicitly, use it for all tables
        $explicitCutoffMonth = $this->option('purge-daily-before') ?
            $this->parseMonth($this->option('purge-daily-before')) : null;

        // Or if purge-daily-range is set, use the last processed month
        if (!$explicitCutoffMonth && $this->option('purge-daily-range') && !empty($processedMonths)) {
            // Find max month
            $last = collect($processedMonths)->sort()->last();
            $explicitCutoffMonth = $last instanceof Carbon ? $last->copy() : $this->parseMonth((string) $last);
        }

        if ($explicitCutoffMonth) {
            $cutoffDate = $explicitCutoffMonth->copy()->endOfMonth();
            $delTotals = DB::table('visitor_daily_totals')->where('date', '<=', $cutoffDate)->delete();
            $delPages = DB::table('visitor_daily_pages')->where('date', '<=', $cutoffDate)->delete();
            $delRegions = DB::table('visitor_daily_regions')->where('date', '<=', $cutoffDate)->delete();

            $this->info("Purged daily totals on/before {$cutoffDate->toDateString()}: {$delTotals} rows");
            $this->info("Purged daily pages on/before {$cutoffDate->toDateString()}: {$delPages} rows");
            $this->info("Purged daily regions on/before {$cutoffDate->toDateString()}: {$delRegions} rows");
            return;
        }

        // Default: retention-based purge relative to today
        $retainDailyMonths = (int) config('services.visitor_analytics.retain_daily_months', 18);
        $retainPagesDailyMonths = (int) config('services.visitor_analytics.retain_pages_daily_months', 12);
        $retainRegionsDailyMonths = (int) config('services.visitor_analytics.retain_regions_daily_months', 12);

        $cutoffTotals = Carbon::today()->startOfMonth()->subMonths($retainDailyMonths);
        $cutoffPages = Carbon::today()->startOfMonth()->subMonths($retainPagesDailyMonths);
        $cutoffRegions = Carbon::today()->startOfMonth()->subMonths($retainRegionsDailyMonths);

        $delTotals = DB::table('visitor_daily_totals')->where('date', '<', $cutoffTotals)->delete();
        $delPages = DB::table('visitor_daily_pages')->where('date', '<', $cutoffPages)->delete();
        $delRegions = DB::table('visitor_daily_regions')->where('date', '<', $cutoffRegions)->delete();

        $this->info("Purged daily totals before {$cutoffTotals->toDateString()}: {$delTotals} rows");
        $this->info("Purged daily pages before {$cutoffPages->toDateString()}: {$delPages} rows");
        $this->info("Purged daily regions before {$cutoffRegions->toDateString()}: {$delRegions} rows");
    }
}
