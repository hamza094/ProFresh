<?php
namespace App\Services\Api\V1;

use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Notifications\ProjectInvitation;
use App\Notifications\AcceptInvitation;
use App\Http\Resources\Api\V1\ProjectsResource;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;


class InvitationService
{
  public function sendInvitation(User $user,Project $project): void
  {
    $this->validateInvitation($project,$user);

    DB::beginTransaction();
    try{
      $project->invite($user);

      $this->recordActivity($project,$user,'invitation_sent');

      $user->notify(new ProjectInvitation($project));

      DB::commit();
    }catch(\Exception $ex){
      DB::rollBack();

      throw $ex;
    }

   }


  public function acceptInvitation(Project $project): void
  {
    $user=Auth::user();

    DB::beginTransaction();  

    try{

    $this->activateMembership($project, $user);
    $this->recordActivity($project,$user,'invitation_accepted');
    $project->user->notify(new AcceptInvitation($project,$user));

     DB::commit();

    }catch(\Exception $ex){

      DB::rollBack();

      throw $ex;
    }
  }


  public function removeMember(User $user,Project $project): void
  {
    $this->validateRemoval($project,$user);

    DB::transaction(function () use ($project,$user){

    $project->members()->detach($user);

    $this->recordActivity($project,$user,'member_removed');
  });
  }
 
  
 /**
 * Get the pending members for the given project.
 *
 * @param \App\Models\Project $project
 * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\User>
 */
  public function pendingMembers(Project $project) : EloquentCollection
  {
    return $project->members()
        ->wherePivot('active', false)
        ->withPivot('created_at')
        ->get();
  }

  /**
 * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\User>
 */
  public function usersSearch(Project $project,Request $request): Collection
  {
    $searchTerm = $request->input('query');

    $users = User::query()
        ->whereAny(['name', 'email'], 'LIKE', '%' . $searchTerm . '%')
        ->select('uuid','name','email')
        ->limit(5)
        ->get();

         return $users;
  }

   /**
     * Reject an invitation for a user.
     *
     * @param Project $project
     * @param User $user
     * @return void
     */
    public function rejectInvitation(Project $project, User $user): void
    {
      $project->members()->detach($user);
    }

     /**
     * Cancel an invitation for a user as a project owner.
     *
     * @param Project $project
     * @param User $user
     * @return void
     */
    public function cancelInvitation(Project $project, User $user): void
    {
        if($user->cannot('canAcceptInvitation', $project)){
            abort(403);
          }

        $project->members()->detach($user);
    }

  protected function recordActivity(Project $project,User $user,string $msg): void
  {
    $project->recordActivity($msg,[$user->id]);
  }

  protected function activateMembership(Project $project,Authenticatable $user): void
  {
    $user->members()->updateExistingPivot($project, ['active' => true]);
  }

   protected function validateInvitation(Project $project,User $user): void
   {
     throw_if(
       $project->members()->where('user_id', $user->id)->exists(),
       ValidationException::withMessages([
        'invitation'=>'Project invitation already sent to a user.'
      ])
    );

     throw_if(
      $user->is($project->user),
      ValidationException::withMessages([
        'invitation'=>"Can't send an invitation to the project owner."
      ])
    );
  }

  protected function validateRemoval(Project $project, User $user): void
  {
    if (!$project->activeMembers()->where('user_id', $user->id)->exists()) {
        throw ValidationException::withMessages([
            'user' => 'This user is not an active member of the project.',
        ]);
    }
}

}

?>
