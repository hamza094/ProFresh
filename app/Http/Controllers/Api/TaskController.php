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
    try {

    $taskService->updateStatus($task, $request->validated('status_id'));

    $task->update($request->validated());

    $keys = array_keys($request->validated());

    $updatedMessage = 'Task ' . implode(', ', $keys);

    return $this->respondWithSuccess([
        'message' => $updatedMessage . ' Updated Successfully',
        'task' => new TaskResource($task),
    ]);

    } catch (\Exception $e) {
    return $this->respondError($e->getMessage());
   }

  }

  public function destroy(Project $project,Task $task)
  {
     $task->activities()->delete();

     $task->delete();  

     return $this->respondNoContent(['message'=>'Task deleted successfully']);
  }

}
