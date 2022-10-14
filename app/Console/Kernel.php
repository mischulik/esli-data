<?php

namespace App\Console;

use App\Actions\Auth\ElsieLoginAction;
use App\Actions\Data\ElsieSearchAction;
use App\Actions\Scheduled\AutomaticUpdateAction;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ElsieLoginAction::class,
        ElsieSearchAction::class,
        AutomaticUpdateAction::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('elsie:update')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
