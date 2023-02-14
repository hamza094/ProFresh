<?php
namespace App\Services;
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
    $filteredTasks = $this->getFilteredTasks($tasks);

    if($filteredTasks){
     request()->validate([
        'tasks.*.body' => ['sometimes','max:55','min:5'],
      ]); 

    $project->addTasks($filteredTasks);
    }
  }

   private function getFilteredTasks($tasks)
   {
     return collect($tasks)->filter(function ($value, $key) {
         return !empty($value['body']);
    });      
  }

    public function sendNotification($project)
   {
     $user = auth()->user()->toArray();

     NotificationAction::send(
           new ProjectUpdated($project,$user),$project);
   }
}



?>
