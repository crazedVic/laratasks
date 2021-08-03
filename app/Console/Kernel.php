<?php

namespace App\Console;

use App\Jobs\NotificationDigest;
use App\Jobs\ProcessTasks;
use App\Jobs\RecurringTasks;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //scanning processes
        //$schedule->job(new ProcessTasks)->everyMinute(); //TODO: make longer than a minute

        //retry then delete old failed queue items once a day
        $schedule->command('queue:retry all')->daily();
        $schedule->command('queue:prune-failed --hours=48')->daily();

        //check if task needs to be copied
        $schedule->job(new RecurringTasks)->everyMinute();

        //weekly notification reminder
        //$schedule->job(new NotificationDigest)->everyMinute(); //TODO: make weekly
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
