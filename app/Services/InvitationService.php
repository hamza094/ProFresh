<?php
namespace App\Services;
use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Notifications\ProjectInvitation;
use App\Notifications\AcceptInvitation;
use App\Helpers\ProjectHelper;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class InvitationService
{
  use ApiResponseHelpers;

  public function sendInvitation($user,$project)
  {
    if ($project->members->contains($user->id))
    {
       return $this->respondError("Project invitation already sent to a user");
    }
      $project->invite($user);

      $this->performRelatedTasks($project,$user);

      return $this->respondWithSuccess([
        'msg'=>"Project invitation sent to ".$user->name
      ]);

   }

  public function acceptInvitation($project)
  {
    Auth::user()->members()->updateExistingPivot($project,['active'=>true]);

    $this->executeRelatedTasks($project,Auth::user());

    return $this->respondWithSuccess([
      'msg'=>"You have accepted, ".$project->name." invitation"
    ]);

    //$this->attachUserToGroupChat($project,Auth::user());
  }

  public function removeMember($user,$project)
  {
     $project->members()->detach($user);

     $project->recordActivity('remove_project_member',$user->name.'/_/'.$user->id);

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

  protected function performRelatedTasks($project,$user)
  {
    $project->recordActivity('sent_invitation_member',$user->name.'/_/'.$user->id);

    $user->notify(new ProjectInvitation($project));
  }

  protected function executeRelatedTasks($project,$user)
  {
    $project->recordActivity('accept_invitation_member',$user->name.'/_/'.$user->id);

    //$project->owner->notify(new AcceptInvitation($project,$user));
  }

   /**
     * Attach User to chat group after accepting project invitation.
     *
     * @param  int  $project, $int user
     */
  protected function attachUserToGroupChat($project,$user)
  {
    $users=[];

    array_push($users,$user->id);

    $project->group->users()->attach($users);
  }

}

?>
