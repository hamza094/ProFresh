<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Task;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class TaskFeatureService
{
    public function assignMembers(Task $task, array $members, Project $project): void
    {
        DB::transaction(function () use ($task, $members, $project): void {
            $task->assignee()->attach($members);
            $this->notifyAssignees($members, $task, $project);
        });

        $task->load('assignee');
    }

    public function archiveTask(Task $task): void
    {
        DB::transaction(function () use ($task): void {
            $task->delete();
        });
    }

    public function unarchiveTask(Task $task): void
    {
        if (! $task->trashed()) {
            abort(403, 'Task must be trashed to perform this action');
        }

        DB::transaction(function () use ($task): void {
            $task->restore();
            $task->activities()->update(['is_hidden' => false]);
        });
    }

    public function removeTask(Task $task): void
    {
        $task->forceDelete();
    }

    private function notifyAssignees($members, Task $task, Project $project)
    {
        $usersToNotify = User::whereIn('id', $members)
            ->where('id', '!=', Auth::id())
            ->select('id', 'name', 'email')
            ->get();

        Notification::send($usersToNotify,
            new TaskAssigned(
                $task->title,
                $project->name,
                $project->path(),
                auth()->user()->getNotifierData()
            ));
    }
}
