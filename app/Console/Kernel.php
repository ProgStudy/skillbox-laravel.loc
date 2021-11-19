<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SendNotificationCreateArticle::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('send:notify-created-article ' . $this->getDateFromOldWeek('Monday') . ' ' . $this->getDateFromOldWeek('Sunday'))
            ->cron('0 12 * * 1');
    }

    private function getDateFromOldWeek($nameDay)
    {
        $day = strtotime('last ' . $nameDay);
        return date('d.m.Y', date('W', $day)==date('W') ? $day-7*86400 : $day);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
