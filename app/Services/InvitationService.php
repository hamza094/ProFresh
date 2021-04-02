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
   /**
     * Send project invitation request.
     *
     * @param  int  $project
     */
  public function sendInvitation($user,$project)
  {
    if (! $project->members->contains($user->id))
    {
     $project->invite($user);

     $this->performRelatedTasks($project,$user);     
   }
  }

  /**
     * Accept project invitation request.
     *
     * @param  int  $project
     */
  public function acceptInvitation($project)
  {
    $user=Auth::user();

    $user->members()->updateExistingPivot($project,['active'=>1]);

    $this->executeRelatedTasks($project,$user);

    $this->attachUserToGroupChat($project,$user);
  }

  /**
     * Cancel project invitation request.
     *
     * @param  int  $project, $int user
     */
  public function cancelInvitation($user,$project)
  {
    $project->members()->detach($user);

    $project->recordActivity('cancel_member_project',$user->name.'/_/'.$user->id);

    $project->scores()->where('message',"Invitaion Accept by $user->name")->delete();
  }
  
    /**
     * Search users to send invitation.
     *
     * @param  int  $project, $int user
     */
  public function memberSearch()
  {
    return (new Search())
     ->registerModel(User::class, ['name', 'email'])
     ->search($request->input('query'));
  }
  
  /**
     * Perform tasks after send project invitation.
     *
     * @param  int  $project, $int user
     */
  protected function performRelatedTasks($project,$user)
  {
    $project->recordActivity('sent_member_project',$user->name.'/_/'.$user->id);

    $user->notify(new ProjectInvitation($project));

    $this->recordScore($project,'Invitaion Sent',5);
  }
  
    /**
     * Perform tasks after accept project invitation.
     *
     * @param  int  $project, $int user
     */
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