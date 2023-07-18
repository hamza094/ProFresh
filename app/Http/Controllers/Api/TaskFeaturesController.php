<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use App\Notifications\TaskAssigned;
use App\Http\Resources\TaskResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class TaskFeaturesController extends Controller
{
    use ApiResponseHelpers;

    public function members(Project $project,Task $task, Request $request)
    {
        $members=[User::first()];

    if (empty($members)) {
        return $this->respondError('No users found to assign.');
    }

    $task->assignee()->attach(collect($members)->pluck('id'));

    $task->assignee->each->notify(new TaskAssigned($task, $project, auth()->user()));

    return $this->respondWithSuccess([
        'message' => 'Task assigned to member Successfully',
        'task' => new TaskResource($task),
    ]);

    }

    
}


