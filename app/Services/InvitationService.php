<?php
namespace App\Services;
use Auth;
use App\User;
use App\Project;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Notifications\ProjectInvitation;
use App\Notifications\AcceptInvitation;

class InvitationService
{

  public function sendInvitation($user,$project)
  {
    if (! $project->members->contains($user->id))
    {
     $project->invite($user);

     $this->performRelatedTasks($project,$user);     
   }
  }

  public function acceptInvitation($project)
  {
    Auth::user()->members()->updateExistingPivot($project,['active'=>1]);

    $this->executeRelatedTasks($project,Auth::user());

    $this->attachUserToGroupChat($project,Auth::user());
  }

  public function cancelInvitation($user,$project)
  {
    $project->members()->detach($user);

    $project->recordActivity('cancel_member_project',$user->name.'/_/'.$user->id);

    $project->scores()->where('message',"Invitaion Accept by $user->name")->delete();
  }
  
  public function memberSearch()
  {
    return (new Search())
     ->registerModel(User::class, ['name', 'email'])
     ->search($request->input('query'));
  }
  
  protected function performRelatedTasks($project,$user)
  {
    $project->recordActivity('sent_member_project',$user->name.'/_/'.$user->id);

    $user->notify(new ProjectInvitation($project));

    $this->recordScore($project,'Invitaion Sent',5);
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