<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class TasksPolicy
{
    use HandlesAuthorization;

    public function taskaccess(User $user,Task $task)
    {
       return  $user->is($task->owner) || $user->is($task->project->user) || $task->assignee->contains($user->id) 
               ? Response::allow()
               : Response::deny("Only Project's owner task owner and assined members are allowed to access this feature.");
    }

    public function taskallow(User $user,Task $task)
    {
       return  $user->is($task->owner) || $user->is($task->project->user) 
               ? Response::allow()
               : Response::deny("Only Project's owner task owner and are allowed to access this feature.");
    }
}
