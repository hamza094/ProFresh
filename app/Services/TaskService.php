<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use App\Models\TaskStatus;
use App\Notifications\ProjectTask;
use Illuminate\Validation\ValidationException;

class TaskService
{ 
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
