<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\TaskDueAction;
use App\Models\Task;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
     */
    public function handle(): int
    {
        Task::dueForNotifications()
            ->with([
                'assignee:id,name',
                'project:id,name,slug',
            ])
            ->chunk(50, fn ($tasks) => $this->processTasks($tasks));

        $this->info('Task notifications sent successfully.');

        return 0;
    }

    /**
     * Process each task in the chunk.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $tasks
     * @return void
     */
    private function processTasks($tasks)
    {
        foreach ($tasks as $task) {
            try {
                if ($this->taskDueAction->shouldNotify($task)) {
                    $this->taskDueAction->sendNotification($task);
                }
            } catch (Exception $e) {
                Log::error('Failed to process task notification', [
                    'task_id' => $task->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
