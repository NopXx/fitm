<?php

namespace App\Providers;

use App\Services\VisitorService;
use App\View\Components\FitmNewsCard;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Blade::component('fitm-news-card', FitmNewsCard::class);
        $this->shareVisitorData();
    }

    private function shareVisitorData(): void
    {
        // ตรวจสอบว่าไม่ใช่การทำงานใน console
        if (!$this->app->runningInConsole()) {
            // ดึงข้อมูลจำนวนผู้เข้าชม
            $visitorService = $this->app->make(VisitorService::class);

            try {
                $todayVisitors = $visitorService->getTodayVisitors(true);
                $totalVisitors = $visitorService->getTotalVisitors(true);

                // แชร์ข้อมูลไปยังทุก view
                view()->share([
                    'todayVisitors' => $todayVisitors,
                    'totalVisitors' => $totalVisitors,
                ]);
            } catch (\Exception $e) {
                // กรณีที่ยังไม่มีตาราง visitors หรือเกิดข้อผิดพลาด
                view()->share([
                    'todayVisitors' => 0,
                    'totalVisitors' => 0,
                ]);
            }
        }
    }
}
