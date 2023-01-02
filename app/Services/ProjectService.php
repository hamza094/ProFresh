<?php
namespace App\Services;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Conversation;

class ProjectService
{
  
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

  public function addTasksToProject($project,$tasks): void
  {
    $filteredTasks = $this->getFilteredProjects($tasks);

    if($filteredTasks){
     request()->validate([
        'tasks.*.body' => ['sometimes','max:55','min:5'],
      ]); 

    $project->addTasks($filteredTasks);
    }

  }

   private function getFilteredProjects($tasks)
   {
     return collect($tasks)->filter(function ($value, $key) {
         return !empty($value['body']);
    });      
  }
}



?>
