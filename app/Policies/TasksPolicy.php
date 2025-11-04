<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TasksPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function access(User $user, Task $task): Response
    {
        return
          $user->is($task->owner) || $user->is($task->project->user) || $task->assignee->contains($user->id)
                ? Response::allow()
                : Response::deny('Access restricted to project, task owner, and assigned members');
    }

    public function manage(User $user, Task $task): Response
    {
        return $user->is($task->owner) || $user->is($task->project->user)
                ? Response::allow()
                : Response::deny("Only Project's owner and task owner are allowed to access this feature.");
    }
}
