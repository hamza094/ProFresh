<?php
namespace App\Services;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Group;

class ProjectService
{

  /**
    * Create Project Group And Intilize Chat Conversation.
    *
    * @param  int  $project
    */
  public function createProjectGroupChat($project)
  {
      $group=$this->createProjectGroup($project);

      $this->attachProjectOwnerToGroup($project,$group);

      $this->initilizeGroupChatting($project,$group);
    }

  protected function createProjectGroup($project)
  {
      return $project->group()->create([
        'name'=> $project->name . " Chat Group",
        'project_id'=> $project->id
      ]);
  }

  protected function attachProjectOwnerToGroup($project,$group)
  {
      $users=[];

      array_push($users, $project->user->id);

      $group->users()->attach($users);

      $project->update(['group_id'=>$group->id]);
  }

  protected function initilizeGroupChatting($project,$group)
   {
     $group->conversations()->create([
        'message'=>"Welcome to ". $project->name,
        'user_id'=>$project->user->id,
        ]);
  }

  public function sameRequestAttributes($project)
  {
      return $project->name == request('name')
      || $project->about == request('about');
  }

  public function sameNoteRequest($project)
  {
     return request()->has('notes')
     && $project->notes == request('notes');
  }

}



?>
