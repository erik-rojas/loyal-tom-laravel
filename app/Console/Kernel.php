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
        'App\Console\Commands\emailClientAdvisor',
        'App\Console\Commands\smsClientAdvisor',
        'App\Console\Commands\emailAdminNotification',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
            $schedule->command('email:ClientAdvisor')
                ->between('4:00', '7:00')
                ->mondays();

            $schedule->command('sms:ClientAdvisor')
                ->between('8:00', '11:00')
                ->tuesdays()
                ->fridays();

            $schedule->command('email:AdminNotification')
                ->dailyAt('08:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
