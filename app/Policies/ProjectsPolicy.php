<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;
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

    public function before(User $user, string $ability): bool|null
    {
      if ($user->isAdmin()) {
          return true;
      }
 
      return null; 
   }

    public function manage(User $user, Project $project): bool
    {
        return $user->is($project->user);
    }

    public function access(User $user, Project $project): Response
    {
        return $user->is($project->user) || $project->activeMembers->contains($user->id) 
               ? Response::allow()
               : Response::deny("Only Project's owner and members are allowed to access this feature.");
    }

    public function zoomAuthorize(User $user, Project $project): bool
    {
      $user->is($project->user) && ! $user->isConnectedToZoom();
    }

    public function canAcceptInvitation(User $user, Project $project): bool
   {
    return $project->members()
        ->where('user_id', $user->id)
        ->wherePivot('active', false)
        ->exists();
   }
}
