<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Helpers\SendNotification;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class TaskController extends ApiController
{
  use ApiResponseHelpers;

  private $notification;

  public function __construct(SendNotification $notification)
  {
    $this->notification=$notification;
  }

  public function store(Project $project,TaskRequest $request,TaskService $taskService)
  {
    $taskService->checkLimits($project);

    $task=$project->tasks()->firstOrCreate($request->validated());

    $taskService->checkRecentlyCreated($task);

    $this->notification->send($project);

    return new TaskResource($task);
  }

  public function update(Project $project,Task $task,TaskRequest $request,TaskService $taskService)
  {
      $validatedData = $request->validated();

      if ($task->body === $validatedData['body']) {
        return $this->respondError("You haven't changed anything");
      }
      
      $task->update($validatedData);

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
