<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\TaskDueNotifies;
use App\Models\Task;
use App\Notifications\TaskDue;
use Illuminate\Support\Facades\DB;

class TaskDueAction
{
    public function shouldNotify(Task $task): bool
    {
        $minutes = TaskDueNotifies::getPeriodInMinutes($task->notified);

        if ($minutes !== null) {
            $notificationTime = $task->due_at->subMinutes($minutes);

            return now() >= $notificationTime;
        }

        return false;
    }

    public function sendNotification(Task $task): void
    {
        DB::transaction(function () use ($task): void {
            $task->notify_sent = true;
            $task->saveQuietly();

            foreach ($task->assignee as $user) {
                $user->notify(
                    new TaskDue(
                        $task->due_at,
                        $task->title,
                        $task->notified,
                        $task->owner->getNotifierData(),
                        $task->project->name,
                        $task->project->path()
                    ));
            }
        });
    }
}
