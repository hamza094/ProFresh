<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user, Project $project)
    {
        return $user->is($project->owner);
    }


    public function access(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->activeMembers->contains($user);
    }
}
