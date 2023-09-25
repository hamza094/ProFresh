<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Actions\TaskDueAction;

class TaskNotify extends Command
{
    protected $signature = 'tasks:notify';

    protected $description = 'Send tasks due notification on scheduled time';

    protected $taskDueAction;

    public function __construct(TaskDueAction $taskDueAction)
    {
        parent::__construct();

        $this->taskDueAction = $taskDueAction;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::dueForNotifications()
            ->with('assignee', 'project')
            ->get();

    foreach ($tasks as $task) {
        if ($this->taskDueAction->shouldNotify($task)) {
            $this->taskDueAction->sendNotification($task);
        }
    }

    $this->info('Task notifications sent successfully.');
    
    }

}
