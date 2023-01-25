<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Helpers\SendNotification;
use App\Http\Resources\TaskResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TaskController extends ApiController
{
  use ApiResponseHelpers;

  private $notification;

  public function __construct(SendNotification $notification)
  {
    $this->notification=$notification;
  }

  public function store(Project $project,TaskRequest $request)
  {
    if($project->tasksReachedItsLimit())
    {
       throw ValidationException::withMessages([
        'task'=>'Project tasks reached their limit',
      ]);
    }

    $task=$project->tasks()->firstOrCreate($request->validated());

    if(!$task->wasRecentlyCreated)
    {
       throw ValidationException::withMessages([
         'task'=>'Project tasks already exist',
       ]);
     }

    $this->notification->send($project);

     return new TaskResource($task);
  }

  public function update(Project $project,Task $task,TaskRequest $request)
  {
    if($task->body == $request->body){
       return $this->respondError("You haven't changed anything");
    }

      $task->update($request->validated());
      return new TaskResource($task);
  }

  public function destroy(Project $project,Task $task)
  {
     $task->activities()->delete();

     $task->delete();  

     return $this->respondNoContent(['message'=>'Task deleted successfully']);
  }

  public function status(Project $project,Task $task)
  {
     request('completed') ? $task->complete() : $task->incomplete();

    return new TaskResource($task);
  }

}
