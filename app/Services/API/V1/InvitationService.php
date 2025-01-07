<?php
namespace App\Services\Api\V1;

use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Notifications\ProjectInvitation;
use App\Notifications\AcceptInvitation;
use App\Http\Resources\Api\V1\ProjectInvitaionResource;
use App\Http\Resources\Api\V1\ProjectsResource;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Support\Facades\DB;
use App\Helpers\ProjectHelper;
use Illuminate\Support\Collection;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

class InvitationService
{
  use ApiResponseHelpers;

  public function sendInvitation(User $user,Project $project): void
  {
    $this->validateInvitation($project,$user);

    DB::beginTransaction();
    try{
      $project->invite($user);

      $this->recordActivity($project,$user,'sent_invitation_member');

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
    $this->recordActivity($project,$user,'accept_invitation_member');
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
    $project->activities->whereIn('subject_id', [$user->id])->each->delete();

    $project->members()->detach($user);

    $this->recordActivity($project,$user,'remove_project_member');
  });

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

  protected function recordActivity(Project $project,User $user,string $msg): void
  {
    $project->recordActivity($msg,$user->name.'/_/'.$user->id);
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
