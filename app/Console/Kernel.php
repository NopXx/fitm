<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\AggregateVisitorStats::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // Aggregate yesterday's stats and purge logs older than 30 days daily at 00:10
        $schedule->command('visitors:aggregate --date=yesterday --purge')->dailyAt('00:10');

        // Monthly rollup: on 1st of every month at 00:30, rollup the previous month and purge old daily
        $schedule->command('visitors:rollup-monthly --purge-daily')
            ->monthlyOn(1, '00:30');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
    }
}
