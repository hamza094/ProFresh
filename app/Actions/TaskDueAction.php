<?php

namespace App\Actions;

use App\Models\Task;
use App\Enums\TaskDueNotifies;
use App\Notifications\TaskDue;
use Illuminate\Support\Facades\DB;

class TaskDueAction
{
    public function shouldNotify(Task $task): bool
    {
        $type = $task->notified;

        $minutes = TaskDueNotifies::getPeriodInMinutes($type);

        if ($minutes !== null) {
            $notificationTime = $task->due_at->subMinutes($minutes);

            return now() >= $notificationTime;
        }

        return false;
    }

    public function sendNotification(Task $task)
    {

        DB::transaction(function () use ($task) {
            $task->notify_sent = true;
            $task->saveQuietly();

            foreach ($task->assignee as $user) {
                $user->notify(new TaskDue($task, $task->owner, $task->project));
            }
        });
    }
}


