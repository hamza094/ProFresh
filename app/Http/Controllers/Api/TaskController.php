<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdate;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Notifications\ProjectTask;
use App\Models\Task;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class TaskController extends ApiController
{
  use ApiResponseHelpers;

  public function store(Project $project,TaskRequest $request,TaskService $taskService)
  {
    $taskService->checkLimits($project);

    $task=$project->tasks()->firstOrCreate($request->validated());

    $taskService->sendNotification($project);    

    return $this->respondCreated([
      'message'=>'Task Created Successfully',
      'task'=>new TaskResource($task),
    ]);
  }

  public function update(Project $project,Task $task,TaskUpdate $request,TaskService $taskService): JsonResponse
  {   
     $validatedData = $request->validated();

    if (isset($validatedData['status_id'])) {
        $taskService->updateStatus($task,$validatedData['status_id']);
    }

      $task->update($validatedData);

      return $this->respondWithSuccess([
      'message'=>'Task Updated Successfully',
      'task'=>new TaskResource($task),
    ]);
  }

  public function destroy(Project $project,Task $task)
  {
     $task->activities()->delete();

     $task->delete();  

     return $this->respondNoContent(['message'=>'Task deleted successfully']);
  }

}
