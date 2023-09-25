<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Gate;
use App\Notifications\TaskAssigned;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Auth;
use App\Http\Resources\TaskResource;
use App\Notifications\ProjectTask;
use Illuminate\Validation\ValidationException;

class TaskService
{ 

  public function getTasksData(Project $project, bool $isArchived): array
    {
      $tasksQuery = $project->tasks()->with('assignee:name,id,username');

      $tasksQuery->when($isArchived, fn($query) => $query->archived(), fn($query) => $query->active());

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
        ['tasks'=>'Project tasks reached their limit'])
      );
  }

  public function updateStatus(Task $task,$statusId): void{
    if (isset($statusId)) {
        $status = TaskStatus::findOrFail($statusId);
        $task->status()->associate($status);
    }
  }

  public function setDueDate($request,$task)
  {
    if($due_at = request()->input('due_at'))
    {
    $formattedTime = (new \DateTime($due_at))->format('Y-m-d H:i:s');

     $task->due_at = \Timezone::convertFromLocal($formattedTime);

     $task->save();
   }
  }

  public function updateValidation($request,$task)
  {
     Gate::authorize('archive-task', $task);

    if(!$request->validated()){
       return $this->respondError('Field missing in task');
    } 
  }


  public function sendNotification($project)
  {
    $user = auth()->user()->toArray();

    NotificationAction::send(
          new ProjectTask($project,$user),$project);
  }

  public function notifyAssignees(Request $request, Task $task, Project $project)
  {
    $usersToNotify = User::whereIn('id', $request->members)
    ->where('id', '!=', Auth::id())
    ->select('id', 'name', 'email')
    ->get();

    $usersToNotify->each->notify(new TaskAssigned($task, $project, auth()->user()));

  }  
}



?>
