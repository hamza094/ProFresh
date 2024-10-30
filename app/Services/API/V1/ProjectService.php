<?php
namespace App\Services\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use App\Notifications\ProjectUpdated;
use App\Models\Conversation;

class ProjectService
{ 

  public function requestAttributesUnchanged(Project $project)
  { 
    return $this->sameRequestAttributes($project) 
    || $this->sameNoteRequest($project);
  }

  private function sameRequestAttributes(Project $project)
  {
      return $project->name === request('name')
      || $project->about === request('about');
  }

  private function sameNoteRequest(Project $project)
  {
     return request()->has('notes')
     && $project->notes === request('notes');
  }

  public function getChangedAttribute($request)
  {
    $requestArray=$request->validated();

    return array_key_first($requestArray);
  }

  public function addTasksToProject($project,$tasks): void
  {    
    $tasksWithUser = collect($tasks['tasks'])->map(fn ($task)=>
        [...$task, 'user_id' => auth()->id()]);

    dd('stop');

    $project->addTasks($tasksWithUser);   
  }

  public function sendNotification($project)
   {
     $user = auth()->user()->toArray();

     NotificationAction::send(
           new ProjectUpdated($project,$user),$project);
   }
}



?>
