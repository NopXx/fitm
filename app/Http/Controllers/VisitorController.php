<?php

namespace App\Http\Controllers;

use App\Services\VisitorService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\VisitorLog;

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
        $data = [
            'activeVisitors' => $this->visitorService->getActiveVisitors(15, true), // ไม่รวมส่วน admin
            'totalVisitors' => $this->visitorService->getTotalVisitors(true),
            'totalPageViews' => $this->visitorService->getTotalPageViews(true),
            'todayVisitors' => $this->visitorService->getTodayVisitors(true),
            'mostVisitedPages' => $this->visitorService->getMostVisitedPages(10, true),
            'topRegions' => $this->visitorService->getTopRegions(10, true) // เพิ่มข้อมูลจังหวัด
        ];

        return view('dashboard.index', $data);
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

    public function apiRegionStats()
    {
        $data = [
            'topRegions' => $this->visitorService->getTopRegions(10, true)
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

        // Validate date range (maximum 90 days to prevent performance issues)
        $daysDiff = $startDate->diffInDays($endDate);
        if ($daysDiff > 90) {
            return response()->json([
                'error' => $locale === 'th' ? 'ช่วงวันที่สูงสุดคือ 90 วัน' : 'Maximum date range is 90 days'
            ], 400);
        }

        // Find the first record date
        $firstRecord = VisitorLog::where(function ($query) {
            $query->where(function ($q) {
                $q->where('page', '!=', 'admin')
                    ->where('page', '!=', 'login')
                    ->where('page', 'not like', 'admin/%')
                    ->where('page', 'not like', 'api/%')
                    ->where('page', 'not like', 'lang/%');
            })->orWhereNull('page');
        })
            ->orderBy('created_at', 'asc')
            ->first();

        // If first record is after startDate, adjust startDate
        if ($firstRecord && Carbon::parse($firstRecord->created_at)->isAfter($startDate)) {
            $startDate = Carbon::parse($firstRecord->created_at)->startOfDay();
        }

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

        // Get visitor stats excluding admin pages
        $visitorStats = VisitorLog::selectRaw('DATE(created_at) as date, COUNT(DISTINCT ip_address) as visitors')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
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

        // Populate data array
        foreach ($visitorStats as $stat) {
            if (isset($dailyStats[$stat->date])) {
                $dailyStats[$stat->date] = (int) $stat->visitors;
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
