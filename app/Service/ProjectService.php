<?php
namespace App\Service;
use App\Project;
use Illuminate\Http\Request;
use App\Conversation;
use App\Group;

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

    /**
    * Create Project Group.
    *
    * @param  int  $project 
    */
  protected function createProjectGroup($project)
  {
     return Group::create([
        'name' => $project->name . " Chat Group",
        'project_id'=>$project->id
      ]); 
  }

  /**
    * Attach project owner with group and associate group to project.
    *
    * @param  int  $project, int $group 
    */
  protected function attachProjectOwnerToGroup($project,$group)
  {
      $users=[];

      array_push($users, $project->user->id);

      $group->users()->attach($users);

      $project->update(['group_id'=>$group->id]); 
  }

   /**
    * Create project group chat first conversation.
    *
    * @param  int  $project, int $group 
    */
   protected function initilizeGroupChatting($project,$group)
   {
     Conversation::create([
        'message'=>"Welcome to ". $project->name,
        'user_id'=>$project->user->id,
        'group_id'=>$group->id
        ]);
  }
  

}

?>
