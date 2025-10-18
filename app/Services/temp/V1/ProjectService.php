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

    $project->addTasks($tasksWithUser->toArray());   
  }

  public function sendNotification($project)
   {
      if ($project->activeMembers->isEmpty()) {
        return;
      }

     $notifier = auth()->user()->getNotifierData();

     NotificationAction::send(
           new ProjectUpdated(
            $project->name,
            $project->path(),
            $notifier
          ),$project);
   }
}



?>
