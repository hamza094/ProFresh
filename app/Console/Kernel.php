<?php

namespace App\Console;
use App\Models\Messages;
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
       $schedule->command('schedule:message')
        ->when(function () {
            return Message::messageScheduled()->exists();
        })->withoutOverlapping();

         $schedule->command('remove:abandon')->daily();
         $schedule->command('queue:prune-batches --hours=48 --unfinished=72')->daily();
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

    protected function bootstrappers()
    {
    return array_merge(
        [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
        parent::bootstrappers(),
    );
    }
}
