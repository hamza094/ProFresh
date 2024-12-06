<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\Api\V1\TaskService;
use App\Repository\TaskRepository;
use App\Http\Resources\Api\V1\TaskResource;
use App\Http\Requests\Api\V1\TaskMembersRequest;
use Illuminate\Support\Facades\Gate;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Validation\ValidationException;
use App\Rules\TaskAssigneeMember;
use Illuminate\Http\JsonResponse;

class TaskFeaturesController extends Controller
{
    use ApiResponseHelpers;

    public function assign(Project $project,Task $task,TaskMembersRequest $request,TaskService $service)
    {
        Gate::authorize('archive-task', $task);

       $members=$request->members;

       DB::transaction(function () use ($task, $members, $service, $request, $project) {
       $task->assignee()->syncWithoutDetaching($members);
       $service->notifyAssignees($request,$task,$project);
       });

    return $this->respondWithSuccess([
        'message' => 'Task assigned to member Successfully',
        'taskMembers' =>  UsersResource::collection($task->assignee),
    ]);
    }

    public function unassign(Project $project,Task $task,Request $request)
    {       
        Gate::authorize('archive-task', $task);

        $request->validate([
        'member' => ['required', 'exists:users,id', 
               new TaskAssigneeMember($task)],
        ]);

    $task->assignee()->detach($request->member);

    $user= User::find($request->member);

    return $this->respondWithSuccess([
        'message' => 'Task member Unassigned',
        'member' => new UsersResource($user),
    ]);
    }

    public function archive(Project $project,Task $task)
    {
      Gate::authorize('archive-task', $task);

      DB::transaction(function () use ($task) {     
        $task->delete();
        $task->activities()->update(['is_hidden' => true]);
      });

      return $this->respondWithSuccess([
        'message' => 'Project task archived successfully',
        'members' => new TaskResource($task),
      ]);

    }

     public function unarchive(Project $project,Task $task)
     {
        DB::transaction(function () use ($task) { 
        $task->restore();
        $task->activities()->update(['is_hidden' => false]);
        });

       return $this->respondWithSuccess([
        'message' => 'Project task unArchived successfully',
        'task' => new TaskResource($task),
    ]);
    }
    
    public function search(Project $project,Task $task,Request $request,TaskRepository $repository)
    { 
      $searchResults = $repository->searchMembers($request,$project,$task);

      return UsersResource::collection($searchResults);
    }
}


