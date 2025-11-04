<?php

declare(strict_types=1);

namespace App\Services\Api\V1;

use App\Actions\NotificationAction;
use App\Notifications\ProjectUpdated;

class ProjectService
{
    public function addTasksToProject($project, array $tasks): void
    {
        $tasksWithUser = collect($tasks['tasks'])->map(fn ($task) => [...$task, 'user_id' => auth()->id()]);

        $project->addTasks($tasksWithUser->toArray());
    }

    public function sendNotification($project): void
    {
        if ($project->activeMembers->isEmpty()) {
            return;
        }

        $notifier = auth()->user()->getNotifierData();

        NotificationAction::send(
            new ProjectUpdated(
                $project->name,
                $project->path(),
                $notifier
            ), $project);
    }
}
