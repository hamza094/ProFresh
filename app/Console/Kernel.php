<?php

namespace App\Console;
use App\Models\Messages;
use App\Models\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\RecalculateProjectHealth;
use App\Models\Project as ProjectModel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\UserProfileDelete::class,
    \App\Console\Commands\RecalculateAllProjectHealth::class,
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


        $schedule->command('tasks:notify')
         ->withoutOverlapping()
         ->runInBackground()
         ->everyTwoMinutes()
         ->when(function () {
            return Task::dueForNotifications()
                    ->count() > 0;
        });       

         $schedule->command('remove:abandon')->daily();
         $schedule->command('queue:prune-batches --hours=48 --unfinished=72')->daily();

        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('01:30');

        $schedule->command('telescope:prune --hours=10')->daily();
        $schedule->command('user:profile-delete')->daily();

    // Daily health score sweep (recalculate persisted health scores)
    $schedule->command('projects:recalculate-health --queue=metrics')->dailyAt('02:00')->name('recalculate-project-health');
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
