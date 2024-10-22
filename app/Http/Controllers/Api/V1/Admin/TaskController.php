<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Admin\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repository\Admin\TaskRepository;

class TaskController extends Controller
{
    use ApiResponseHelpers;

    public function index(TaskRepository $taskRepository,Request $request)
  {
    $perPage = 50;

    $tasks = $taskRepository->getTasksWithFilter($request, $perPage);

        if($tasks->isEmpty()){
         return $this->respondWithSuccess([
        'message'=>'Sorry no releated tasks found',
    ]);
    }
       return TaskResource::collection($tasks);
    }

    public function bulkDelete(Request $request)
    {
        $taskIds = $request->input('task_ids', []);

    DB::beginTransaction();

    try {
        Task::withTrashed()->whereIn('id', $taskIds)->each(function ($task) {
            // Detach assignees before force deleting
            $task->assignee()->detach();

            // Force delete the task
            $task->forceDelete();
        });

        DB::commit(); // Commit the transaction

        return $this->respondWithSuccess([
            'message' => 'Tasks deleted Successfully',
        ]);
    } catch (\Exception $e) {
        DB::rollBack(); // Roll back the transaction on exception
        return $this->respondWithError([
            'message' => 'Failed to delete tasks: ' . $e->getMessage(),
        ]);
    } 

    }
}
