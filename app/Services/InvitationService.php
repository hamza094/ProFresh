<?php
namespace App\Services;
use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Notifications\ProjectInvitation;
use App\Notifications\AcceptInvitation;
use Illuminate\Support\Facades\DB;
use App\Helpers\ProjectHelper;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class InvitationService
{
  use ApiResponseHelpers;

  public function sendInvitation($user,$project)
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

      return $this->respondWithSuccess([
        'msg'=>"Project invitation sent to ".$user->name
      ]);

   }

  public function acceptInvitation($project)
  {
    $user=Auth::user();

    DB::beginTransaction();

    try{

    $user->members()->updateExistingPivot($project,['active'=>true]);

    $this->recordActivity($project,$user,'accept_invitation_member');

    $project->user->notify(new AcceptInvitation($project,$user->toArray()));

     DB::commit();

    }catch(\Exception $ex){

      DB::rollBack();

      throw $ex;
    }

    return $this->respondWithSuccess([
      'msg'=>"You have accepted, ".$project->name." invitation"
    ]);
  }

  public function removeMember($user,$project)
  {
     $project->members()->detach($user);

     $this->recordActivity($project,$user,'remove_project_member');

     return $this->respondWithSuccess([
      'msg'=>"Member ".$user->name." has been removed from a project",
      'members'=>$project->activeMembers(),
    ]);

  }

  public function memberSearch($request)
  {
    if($request->input('query') != null)
    {
      return (new Search())
       ->registerModel(User::class, ['name', 'email'])
       ->search($request->input('query'));
   }
  }

  protected function recordActivity($project,$user,$msg)
  {
    $project->recordActivity($msg,$user->name.'/_/'.$user->id);
  }

   protected function validateInvitation($project,$user)
   {
     if ($project->members->contains($user->id))
     {
      throw ValidationException::withMessages([
        'invitation'=>'Project invitation already sent to a user.',
      ]);
     }

     if ($user->id == $project->user->id)
     {
      throw ValidationException::withMessages([
      'invitation'=>"Can't send an invitation to the project owner.",
      ]);
     }
   } 
}

?>
