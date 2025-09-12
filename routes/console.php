<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Seed sample visitor_logs data for testing
Artisan::command('dev:seed-visitor-logs {count=100}', function (int $count = 100) {
    $ua = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36';

    // Basic sample pages (avoid admin paths)
    $pages = [
        '', '/', 'news', 'news/1', 'news/2', 'news/3',
        'contents/intro', 'contents/about', 'contents/contact',
        'search', 'departments/1', 'departments/2', 'symbol', 'history'
    ];

    // Helper to generate a random public-looking IP
    $randIp = function () {
        // Avoid private ranges; use 11.x.x.x - 223.x.x.x (roughly)
        $a = rand(11, 223);
        $b = rand(0, 255);
        $c = rand(0, 255);
        $d = rand(1, 254);
        return "$a.$b.$c.$d";
    };

    $now = Carbon::now();
    $rows = [];

    for ($i = 0; $i < $count; $i++) {
        // Distribute dates over past N days (distinct dates if count <= 120)
        $daysAgo = $i; // 0..count-1 days ago
        $created = $now->copy()->subDays($daysAgo)->setTime(rand(0, 23), rand(0, 59), rand(0, 59));

        $rows[] = [
            'ip_address' => $randIp(),
            'user_agent' => $ua,
            'page' => $pages[array_rand($pages)],
            'created_at' => $created,
            'updated_at' => $created,
        ];
    }

    DB::table('visitor_logs')->insert($rows);

    $this->info("Inserted {$count} rows into visitor_logs.");
})->purpose('Insert sample visitor_logs rows for testing');
