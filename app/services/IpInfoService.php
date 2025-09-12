<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IpInfoService
{
    private $token;
    private $cacheTime = 86400; // 24 ชั่วโมง

    public function __construct()
    {
        $this->token = config('services.ipinfo.token');
    }

    public function getLocationData($ip)
    {
        // ไม่ดึงข้อมูลสำหรับ IP ภายใน
        if ($this->isLocalIp($ip)) {
            return [
                'region' => 'Local'
            ];
        }

        // ลองเรียกข้อมูลจาก Cache ก่อน
        $cacheKey = 'ipinfo_' . $ip;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // หากไม่มีโทเค็น หรือสภาพแวดล้อมจำกัดเน็ตเวิร์ก ให้คืน Unknown ทันที
        if (empty($this->token)) {
            return [
                'region' => 'Unknown',
            ];
        }

        try {
            $response = Http::timeout(2)
                ->connectTimeout(1)
                ->retry(0)
                ->get("https://ipinfo.io/{$ip}?token={$this->token}");

            if ($response->successful()) {
                $data = $response->json();

                // เก็บข้อมูลลง Cache
                Cache::put($cacheKey, $data, $this->cacheTime);

                return $data;
            }
        } catch (\Exception $e) {
            // บันทึกข้อผิดพลาด
            Log::error('IP Info API Error: ' . $e->getMessage());
        }

        return [
            'region' => 'Unknown'
        ];
    }

    private function isLocalIp($ip)
    {
        return in_array($ip, ['127.0.0.1', '::1']) ||
               substr($ip, 0, 8) === '192.168.' ||
               substr($ip, 0, 3) === '10.' ||
               substr($ip, 0, 7) === '172.16.';
    }
}
