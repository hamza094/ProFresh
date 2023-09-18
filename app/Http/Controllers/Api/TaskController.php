<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdate;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Notifications\ProjectTask;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use F9Web\ApiResponseHelpers;
use App\Notifications\TaskDue;
use Auth;
use Illuminate\Http\JsonResponse;

class TaskController extends ApiController
{
  use ApiResponseHelpers;

  public function index(Project $project,Request $request,TaskService $taskService): JsonResponse
  {
    $isArchived = ($request->query('request') === 'archived') ? true : false;

    $tasksData = $taskService->getTasksData($project, $isArchived);

    return $this->respondWithSuccess($tasksData);
  }

  public function store(Project $project,TaskRequest $request,TaskService $taskService): JsonResponse
  {
    $this->authorize('access',$project);

    $taskService->checkLimits($project);

    $task=$project->tasks()->firstOrCreate($request->validated()+['user_id' => Auth::id()]);

    $taskService->sendNotification($project); 

    $task->load('status');   

    return $this->respondCreated([
      'message'=>'Task added Successfully',
      'task'=>new TaskResource($task),
    ]);
  }

  public function update(Project $project,Task $task,TaskUpdate $request,TaskService $taskService)
  {  
    $this->authorize('taskaccess',$task);

    $taskService->updateValidation($request,$task);

     DB::transaction(function () use ($task, $request, $taskService)
     {    
        $taskService->updateStatus($task, $request->validated('status_id'));

        $task->update($request->validated());
    });

       $taskService->setDueDate($request,$task);
   
    return $this->respondWithSuccess([
        'message' => 'Task Updated Successfully',
        'task' => new TaskResource($task),
    ]);
  }

  public function destroy(Project $project,Task $task)
  {
    $this->authorize('taskallow',$task);

     $task->activities()->delete();

     $task->forceDelete();  

     return $this->respondNoContent(['message'=>'Task deleted successfully']);
  }

}
