<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use App\Models\TaskStatus;
use App\Models\Project;
use App\Http\Resources\TaskResource;
use App\Notifications\ProjectTask;
use Illuminate\Validation\ValidationException;

class TaskService
{ 

  public function getTasksData(Project $project, bool $isArchived)
    {
        $tasksQuery = $project->tasks();

        if ($isArchived) {
            $tasksQuery->archived();
        } else {
            $tasksQuery->active();
        }

        $tasks = $tasksQuery->get();

       $message = $tasks->isEmpty()
            ? 'Sorry, no tasks found.'
            : $this->getMessage($isArchived);

         $tasksData = TaskResource::collection($tasks);

        if (!$isArchived) {
            $tasksData = $tasksData->paginate(3);
        }

        return compact('message', 'tasksData');
    }

    private function getMessage(bool $isArchived): string
    {
      return 'Project ' . ($isArchived ? 'Archived' : 'Active') . ' Tasks';
    }

  public function checkLimits($project)
  {
    throw_if($project->tasksReachedItsLimit(),
      ValidationException::withMessages(
        ['members'=>'Project tasks reached their limit'])
      );
  }

  public function updateStatus($task,$statusId): void{
    if (isset($statusId)) {
        $status = TaskStatus::findOrFail($statusId);
        $task->status()->associate($status);
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
