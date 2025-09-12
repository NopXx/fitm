<?php

namespace App\Http\Controllers;

use App\Services\VisitorService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\DB;

class VisitorController extends Controller
{
    protected VisitorService $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    public function shareVisitorData()
    {
        // ดึงข้อมูลจำนวนผู้เข้าชม
        $todayVisitors = $this->visitorService->getTodayVisitors(true);
        $totalVisitors = $this->visitorService->getTotalVisitors(true);

        // แชร์ข้อมูลไปยังทุก view
        view()->share([
            'todayVisitors' => $todayVisitors,
            'totalVisitors' => $totalVisitors,
        ]);
    }

    public function dashboard()
    {
        // แสดงหน้าแดชบอร์ด โดยให้ฝั่ง View ไปเรียกข้อมูลผ่าน API เอง
        return view('dashboard.index');
    }

    public function apiStats()
    {
        // ดึงข้อมูลสถิติโดยไม่รวมส่วน /admin/*
        $data = [
            'activeVisitors' => $this->visitorService->getActiveVisitors(15, true), // ส่งพารามิเตอร์ excludeAdmin = true
            'totalVisitors' => $this->visitorService->getTotalVisitors(true),
            'totalPageViews' => $this->visitorService->getTotalPageViews(true),
            'todayVisitors' => $this->visitorService->getTodayVisitors(true)
        ];

        return response()->json($data);
    }

    public function apiRegionStats(Request $request)
    {
        // Optional date range filtering using summary tables
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            $start = \Carbon\Carbon::parse($startDate)->startOfDay();
            $end = \Carbon\Carbon::parse($endDate)->endOfDay();

            $rows = DB::table('visitor_daily_regions')
                ->selectRaw('region, SUM(`count`) as total')
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->groupBy('region')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            // Fallback to monthly summary if no daily data found
            if ($rows->isEmpty()) {
                $startMonth = $start->copy()->startOfMonth()->toDateString();
                $endMonth = $end->copy()->startOfMonth()->toDateString();

                $rows = DB::table('visitor_monthly_regions')
                    ->selectRaw('region, SUM(`count`) as total')
                    ->whereBetween('month', [$startMonth, $endMonth])
                    ->groupBy('region')
                    ->orderByDesc('total')
                    ->limit(10)
                    ->get();
            }

            $topRegions = $rows->map(fn($r) => ['region' => $r->region ?? 'Unknown', 'count' => (int)$r->total])->toArray();

            return response()->json(['topRegions' => $topRegions]);
        }

        // Fallback: use service (recent window via logs)
        $data = [
            'topRegions' => $this->visitorService->getTopRegions(10, true)
        ];

        return response()->json($data);
    }

    public function apiMostVisited(Request $request)
    {
        // If a date range is supplied, use summary table visitor_daily_pages
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($startDate && $endDate) {
            $start = \Carbon\Carbon::parse($startDate)->startOfDay();
            $end = \Carbon\Carbon::parse($endDate)->endOfDay();

            $rows = DB::table('visitor_daily_pages')
                ->selectRaw('COALESCE(page, "") as page, SUM(visits) as total')
                ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
                ->groupBy('page')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            // Fallback to monthly summary if no daily data found
            if ($rows->isEmpty()) {
                $startMonth = $start->copy()->startOfMonth()->toDateString();
                $endMonth = $end->copy()->startOfMonth()->toDateString();

                $rows = DB::table('visitor_monthly_pages')
                    ->selectRaw('COALESCE(page, "") as page, SUM(visits) as total')
                    ->whereBetween('month', [$startMonth, $endMonth])
                    ->groupBy('page')
                    ->orderByDesc('total')
                    ->limit(10)
                    ->get();
            }

            $mostVisited = $rows->map(function ($r) {
                $page = $r->page;
                if ($page === '' || $page === null) {
                    $page = 'Homepage';
                }
                return [
                    'page' => $page,
                    'visits' => (int)$r->total,
                ];
            })->toArray();

            return response()->json(['mostVisitedPages' => $mostVisited]);
        }

        // Fallback to service using raw logs (recent window)
        $data = [
            'mostVisitedPages' => $this->visitorService->getMostVisitedPages(10, true)
        ];

        return response()->json($data);
    }

    public function apiDailyStats(Request $request)
    {
        // Get current application locale (th or en)
        $locale = app()->getLocale();

        // Set Carbon locale based on application locale
        Carbon::setLocale($locale);

        // Get dates from request or default to last 30 days
        $endDate = $request->has('end_date')
            ? Carbon::parse($request->input('end_date'))
            : Carbon::today();

        $startDate = $request->has('start_date')
            ? Carbon::parse($request->input('start_date'))
            : Carbon::today()->subDays(29);

        // Decide aggregation granularity
        $daysDiff = $startDate->diffInDays($endDate);
        $group = $request->input('group', 'auto'); // auto|daily|monthly
        $useMonthly = ($group === 'monthly') || ($group === 'auto' && $daysDiff > 120);

        if ($useMonthly) {
            // Monthly aggregation using visitor_monthly_totals
            $startMonth = $startDate->copy()->startOfMonth();
            $endMonth = $endDate->copy()->startOfMonth();

            $monthlyStats = [];
            $categories = [];

            for ($m = $startMonth->copy(); $m->lte($endMonth); $m->addMonth()) {
                $key = $m->format('Y-m');
                if ($locale === 'th') {
                    $label = $this->getThaiMonth($m->format('n')) . ' ' . substr((intval($m->format('Y')) + 543), 2);
                } else {
                    $label = $m->format('M y');
                }
                $categories[] = $label;
                $monthlyStats[$key] = 0;
            }

            $rows = DB::table('visitor_monthly_totals')
                ->selectRaw('month, unique_visitors')
                ->whereDate('month', '>=', $startMonth->toDateString())
                ->whereDate('month', '<=', $endMonth->toDateString())
                ->get();

            foreach ($rows as $row) {
                $key = \Carbon\Carbon::parse($row->month)->format('Y-m');
                if (isset($monthlyStats[$key])) {
                    $monthlyStats[$key] = (int) $row->unique_visitors;
                }
            }

            return response()->json([
                'visitors' => array_values($monthlyStats),
                'categories' => $categories,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'locale' => $locale,
                'aggregation' => 'monthly',
            ]);
        }

        // Keep the requested range intact to display continuous dates (fill missing with 0)

        // Initialize arrays for stats and categories
        $dailyStats = [];
        $categories = [];

        // Create date array with proper formatting based on locale
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');

            // Format date based on locale
            if ($locale === 'th') {
                // Thai date format (e.g., 1 มี.ค. 67)
                $thaiDate = $date->format('j ') . $this->getThaiMonth($date->format('n')) . ' ' . substr((intval($date->format('Y')) + 543), 2);
                $categories[] = $thaiDate;
            } else {
                // English date format (e.g., 1 Mar 24)
                $categories[] = $date->format('j M y');
            }

            $dailyStats[$formattedDate] = 0;
        }

        // Prefer reading from daily summary table for performance and retention
        $summaryRows = DB::table('visitor_daily_totals')
            ->selectRaw('date, unique_visitors')
            ->whereDate('date', '>=', $startDate->format('Y-m-d'))
            ->whereDate('date', '<=', $endDate->format('Y-m-d'))
            ->get();

        foreach ($summaryRows as $row) {
            $key = \Carbon\Carbon::parse($row->date)->format('Y-m-d');
            if (isset($dailyStats[$key])) {
                $dailyStats[$key] = (int) $row->unique_visitors;
            }
        }

        // For recent dates (within the last 30 days) where summary might not exist yet, fallback to raw logs
        $thirtyDaysAgo = \Carbon\Carbon::today()->subDays(30);
        $needRawDates = [];
        foreach ($dailyStats as $date => $value) {
            $dateObj = \Carbon\Carbon::parse($date);
            if ($dateObj->gte($thirtyDaysAgo) && $value === 0) {
                $needRawDates[] = $date;
            }
        }

        if (!empty($needRawDates)) {
            $visitorStats = VisitorLog::selectRaw('DATE(created_at) as date, COUNT(DISTINCT ip_address) as visitors')
                ->whereDate('created_at', '>=', min($needRawDates))
                ->whereDate('created_at', '<=', max($needRawDates))
                ->where(function ($query) {
                    $query->where(function ($q) {
                        $q->where('page', '!=', 'admin')
                            ->where('page', '!=', 'login')
                            ->where('page', 'not like', 'admin/%')
                            ->where('page', 'not like', 'api/%')
                            ->where('page', 'not like', 'lang/%');
                    })->orWhereNull('page');
                })
                ->groupBy('date')
                ->get();

            foreach ($visitorStats as $stat) {
                if (isset($dailyStats[$stat->date]) && in_array($stat->date, $needRawDates, true)) {
                    $dailyStats[$stat->date] = (int) $stat->visitors;
                }
            }
        }

        // Format response data
        $visitors = array_values($dailyStats);

        return response()->json([
            'visitors' => $visitors,
            'categories' => $categories,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'locale' => $locale
        ]);
    }

    /**
     * Convert month number to abbreviated Thai month name
     *
     * @param int $month
     * @return string
     */
    private function getThaiMonth($month)
    {
        $thaiMonths = [
            1 => 'ม.ค.',
            2 => 'ก.พ.',
            3 => 'มี.ค.',
            4 => 'เม.ย.',
            5 => 'พ.ค.',
            6 => 'มิ.ย.',
            7 => 'ก.ค.',
            8 => 'ส.ค.',
            9 => 'ก.ย.',
            10 => 'ต.ค.',
            11 => 'พ.ย.',
            12 => 'ธ.ค.'
        ];

        return $thaiMonths[(int)$month] ?? '';
    }

    /**
     * แปลงเลขเดือนเป็นชื่อเดือนภาษาไทยแบบย่อ
     *
     * @param int $month
     * @return string
     */
}
