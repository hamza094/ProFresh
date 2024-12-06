<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\TaskRequest;
use App\Http\Requests\Api\V1\TaskUpdate;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use App\Services\Api\V1\TaskService;
use App\Http\Resources\Api\V1\TaskResource;
use App\Http\Resources\Api\V1\TasksResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Gate;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskController extends ApiController
{
   /**
     * Retrieve Project Tasks.
     * 
     * This endpoint fetches all tasks related to a specific project.
     * 
     *  - Archived tasks are returned without pagination.
     *- Active tasks are paginated for easier navigation.
     * 
     * @response AnonymousResourceCollection<LengthAwarePaginator<TasksResource>>
     */
  public function index(Project $project,Request $request,TaskService $taskService): JsonResponse
  {
    $this->authorize('access', $project);

    $validated = $request->validate([
      'request' => 'nullable|in:archived',
    ]);

    $isArchived = ($validated['request'] ?? null) === 'archived';

    $tasksData = $taskService->getTasksData($project, $isArchived);

    return response()->json($tasksData,200);
  }

  /**
   * Create a New Task.
   * 
   * This endpoint allows creating a new task related to a specific project.
  */ 

  public function store(Project $project,TaskRequest $request,TaskService $taskService): JsonResponse
  {
    $this->authorize('access',$project);

    $task=$project->tasks()->firstOrCreate(
      $request->validated()+['user_id' => Auth::id()
     ]);

    $taskService->sendNotification($project);

    $task->load('status'); 

    return response()->json([
      'message' => 'Task added Successfully',
      'task'=>new TasksResource($task),
      ], 201);  

  }

  /** Show Task Details
   * 
   * This endpoint retrieves detailed information about a specific task within a project.
   */
    public function show(Project $project,Task $task)
    {
      $this->authorize('access',$project);

      $task->load(['status','assignee']); 

      return new TaskResource($task);
    }

    /**
   * Update a Task
   * 
   * This endpoint allows you to update the details of a specific task associated with a given project.
 * The user must have proper authorization to access and modify the task.
  */
  public function update(Project $project,Task $task,TaskUpdate $request,TaskService $taskService)
  {
    $taskService->checkValidation($request,$task);

    $this->authorize('taskaccess',$task);
   
    $task->update($request->validated());

      return response()->json([
       'message' => 'Task Updated Successfully',
       'task' => new TaskResource($task),
      ], 200); 
  }


   /**
   * Delete a Task
   * 
   * This endpoint allows you to delete a specific  task associated with a project.
   * 
  ** **Authorization:** 
 * - The user must have appropriate permissions to access and delete the task.
 *
 *  **Functionality:**
 * - Deletes all associated activities of the task.
 * - Permanently removes the task from the database (force delete). 
*/
  public function destroy(Project $project,Task $task)
  {
    $this->authorize('taskallow',$task);

     $task->activities()->delete();

     $task->forceDelete();  

    return response()->json(['message'=>'Task deleted successfully'], 204);
  }

}
