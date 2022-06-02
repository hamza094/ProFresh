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

      return $this->respondWithSuccess([
        'msg'=>"Project invitation sent to ".$user->name
      ]);

     //$this->performRelatedTasks($project,$user);
   }

  public function acceptInvitation($project)
  {
    Auth::user()->members()->updateExistingPivot($project,['active'=>true]);

    return $this->respondWithSuccess([
      'msg'=>"You have accepted, ".$project->name." invitation"
    ]);

    //$this->executeRelatedTasks($project,Auth::user());

    //$this->attachUserToGroupChat($project,Auth::user());
  }

  public function removeMember($user,$project)
  {
     $project->members()->detach($user);

    return $this->respondWithSuccess([
      'msg'=>"Member ".$user->name." has been removed from a project",
      'members'=>$project->activeMembers(),
    ]);

    //$project->recordActivity('cancel_member_project',$user->name.'/_/'.$user->id);

    //$project->scores()->where('message',"Invitaion Accept by $user->name")->delete();
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
    $project->recordActivity('sent_member_project',$user->name.'/_/'.$user->id);

    $user->notify(new ProjectInvitation($project));

    ProjectHelper::recordScore($project,'Invitaion Sent',5);
  }

  protected function executeRelatedTasks($project,$user)
  {
    $project->recordActivity('accept_member_project',$user->name.'/_/'.$user->id);

    $project->owner->notify(new AcceptInvitation($project,$user));

    $project->addScore("Invitaion Accept by $user->name",15);
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
