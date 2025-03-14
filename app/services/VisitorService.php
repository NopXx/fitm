<?php

namespace App\Services;

use App\Models\Visitor;
use App\Models\VisitorLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorService
{
    public function recordVisit(Request $request): void
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $page = $request->path();

        // ตรวจสอบพาธที่ต้องการยกเว้น - แก้ไขเงื่อนไขให้ถูกต้อง
        if (
            $page === 'admin' ||
            $page === 'login' ||
            strpos($page, 'admin/') === 0 ||
            strpos($page, 'api/') === 0 ||
            strpos($page, 'admin/api/') === 0 ||
            strpos($page, 'lang/') === 0
        ) {
            // ไม่บันทึกการเข้าชมในส่วน admin, login, api และอื่นๆ
            return;
        }

        // บันทึกลงในตาราง visitors (ปรับปรุงข้อมูลถ้ามี IP นี้อยู่แล้ว)
        Visitor::updateOrCreate(
            ['ip_address' => $ipAddress],
            [
                'user_agent' => $userAgent,
                'page' => $page,
                'last_visit' => now()
            ]
        );

        // บันทึกลงในตาราง visitor_logs (บันทึกทุกครั้งที่มีการเข้าชม)
        VisitorLog::create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'page' => $page
        ]);
    }

    public function getActiveVisitors(int $minutes = 15, bool $excludeAdmin = false): int
    {
        // นับจำนวนผู้เข้าชมที่กำลังใช้งานในช่วง x นาทีที่ผ่านมา
        $timeThreshold = Carbon::now()->subMinutes($minutes);

        $query = Visitor::where('last_visit', '>=', $timeThreshold);

        // ไม่รวมส่วน admin และอื่นๆ
        if ($excludeAdmin) {
            $query->where(function ($q) {
                $q->where(function ($query) {
                    $query->where('page', '!=', 'admin')
                        ->where('page', '!=', 'login')
                        ->where('page', 'not like', 'admin/%')
                        ->where('page', 'not like', 'api/%')
                        ->where('page', 'not like', 'lang/%');
                })->orWhereNull('page');
            });
        }

        return $query->count();
    }

    public function getTotalVisitors(bool $excludeAdmin = false): int
    {
        // นับจำนวนผู้เข้าชมทั้งหมด (unique IP addresses)
        if ($excludeAdmin) {
            return Visitor::where(function ($query) {
                $query->where(function ($q) {
                    $q->where('page', '!=', 'admin')
                        ->where('page', '!=', 'login')
                        ->where('page', 'not like', 'admin/%')
                        ->where('page', 'not like', 'api/%')
                        ->where('page', 'not like', 'lang/%');
                })->orWhereNull('page');
            })->count();
        }

        return Visitor::count();
    }

    public function getTotalPageViews(bool $excludeAdmin = false): int
    {
        // นับจำนวนการเข้าชมทั้งหมด (รวมการเข้าชมซ้ำ)
        if ($excludeAdmin) {
            return VisitorLog::where(function ($query) {
                $query->where(function ($q) {
                    $q->where('page', '!=', 'admin')
                        ->where('page', '!=', 'login')
                        ->where('page', 'not like', 'admin/%')
                        ->where('page', 'not like', 'api/%')
                        ->where('page', 'not like', 'lang/%');
                })->orWhereNull('page');
            })->count();
        }

        return VisitorLog::count();
    }

    public function getTodayVisitors(bool $excludeAdmin = false): int
    {
        // นับจำนวนผู้เข้าชมวันนี้
        $today = Carbon::today();

        $query = VisitorLog::whereDate('created_at', $today);

        // ไม่รวมส่วน admin และอื่นๆ
        if ($excludeAdmin) {
            $query->where(function ($q) {
                $q->where(function ($query) {
                    $query->where('page', '!=', 'admin')
                        ->where('page', '!=', 'login')
                        ->where('page', 'not like', 'admin/%')
                        ->where('page', 'not like', 'api/%')
                        ->where('page', 'not like', 'lang/%');
                })->orWhereNull('page');
            });
        }

        return $query->distinct('ip_address')->count('ip_address');
    }

    public function getMostVisitedPages(int $limit = 10, bool $excludeAdmin = false): array
    {
        // หาหน้าที่มีผู้เข้าชมมากที่สุด
        $query = VisitorLog::selectRaw('page, count(*) as visits');

        // ไม่รวมส่วน admin และอื่นๆ
        if ($excludeAdmin) {
            $query->where(function ($q) {
                $q->where(function ($query) {
                    $query->where('page', '!=', 'admin')
                        ->where('page', '!=', 'login')
                        ->where('page', 'not like', 'admin/%')
                        ->where('page', 'not like', 'api/%')
                        ->where('page', 'not like', 'lang/%');
                })->orWhereNull('page');
            });
        }

        return $query->groupBy('page')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
