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
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

class InvitationService
{
  use ApiResponseHelpers;

  public function sendInvitation($user,$project): JsonResponse
  {
    try{

      $this->validateInvitation($project,$user);

      DB::beginTransaction();

      $project->invite($user);

      $this->recordActivity($project,$user,'sent_invitation_member');

      $user->notify(new ProjectInvitation($project));

      DB::commit();

      return $this->respondWithSuccess([
        'message'=>"Project invitation sent to ".$user->name,
        'project'=>new ProjectsResource($project)
      ]);

    }catch(\Exception $ex){

      DB::rollBack();

      throw $ex;
    }
   }

  public function acceptInvitation(Project $project): JsonResponse
  {
    try{

    $user=Auth::user();

    DB::beginTransaction();  

    $user->members()->updateExistingPivot($project,['active'=>true]);

    $this->recordActivity($project,$user,'accept_invitation_member');

    $project->user->notify(new AcceptInvitation($project,$user->toArray()));

     DB::commit();

    return $this->respondWithSuccess([
      'message'=>"You have accepted Project invitation",
      'project'=>new ProjectsResource($project)
    ]);

    }catch(\Exception $ex){

      DB::rollBack();

      throw $ex;
    }
  }

  public function removeMember($user,$project): JsonResponse
  {
    DB::transaction(function () use ($project, $user) {

    $project->activities->whereIn('subject_id', $user->id)
            ->each->delete();

    $project->members()->detach($user);

    $this->recordActivity($project,$user,'remove_project_member');

  });

    return $this->respondWithSuccess([
      'message'=>"Member {$user->name} has been removed from the project",
      'user'=>new UsersResource($user),
    ]);
  }

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

  protected function recordActivity($project,$user,$msg)
  {
    $project->recordActivity($msg,$user->name.'/_/'.$user->id);
  }

   protected function validateInvitation($project,$user): void
   {
     throw_if(
       $project->members->contains($user->id),
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
}

?>
