<?php
namespace App\Services\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use App\Notifications\ProjectUpdated;
use App\Models\Conversation;

class ProjectService
{ 

  public function addTasksToProject($project,$tasks): void
  {    
    $tasksWithUser = collect($tasks['tasks'])->map(fn ($task)=>
        [...$task, 'user_id' => auth()->id()]);

    $project->addTasks($tasksWithUser);   
  }

  public function sendNotification($project)
   {
      if ($project->activeMembers->isEmpty()) {
        return;
      }

     $user = auth()->user()->toArray();

     NotificationAction::send(
           new ProjectUpdated($project,$user),$project);
   }
}



?>
