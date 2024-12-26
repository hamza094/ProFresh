<?php
namespace App\Services\Api\V1\Task;

use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Gate;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Auth;
use App\Http\Resources\Api\V1\TaskResource;
use App\Http\Resources\Api\V1\TasksResource;
use App\Notifications\ProjectTask;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Notification;

class TaskService
{ 

  public function getTasksData(Project $project, bool $isArchived): array
    {
      $tasks = $this->getTasks($project,$isArchived);

       $message = $tasks->isEmpty()
            ? 'Sorry, no tasks found.'
            : $this->getMessage($isArchived);

          $tasksData =  $isArchived
           ? TasksResource::collection($tasks)
           : TasksResource::collection($tasks)->paginate(3);

        return compact('message', 'tasksData');
    }

    private function getTasks($project,$isArchived)
    {
      return $project->tasks()
      ->with('project')
      ->when($isArchived, 
        fn($query) => $query->archived(), 
        fn($query) => $query->active());
    }

    private function getMessage(bool $isArchived): string
    {
      return 'Project ' . ($isArchived ? 'Archived' : 'Active') . ' Tasks';
    }

   public function checkValidation($request,$task)
   {
    Gate::authorize('archive-task', $task);
 
      if (!$request->validated()) {
        throw ValidationException::withMessages([
            'task' => ['Field missing in task'],
        ]);
    }
  }

  public function sendNotification($project)
  {
    $user = auth()->user()->toArray();

    NotificationAction::send(
          new ProjectTask($project,$user),$project);
  }


}



?>
