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
use App\Http\Requests\TaskMembersRequest;
use Illuminate\Support\Facades\Gate;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UsersResource;
use Illuminate\Validation\ValidationException;
use App\Rules\TaskAssigneeMember;
use Illuminate\Http\JsonResponse;

class TaskFeaturesController extends Controller
{
    use ApiResponseHelpers;

    public function assign(Project $project,Task $task,TaskMembersRequest $request)
    {
        Gate::authorize('archive-task', $task);

        $this->authorize('taskallow',$task);

       $members=$request->members;

       $task->assignee()->syncWithoutDetaching($members);

    $task->assignee->each->notify(new TaskAssigned($task, $project, auth()->user()));

    return $this->respondWithSuccess([
        'message' => 'Task assigned to member Successfully',
        'taskMembers' =>  UsersResource::collection($task->assignee),
    ]);
    }

    public function unassign(Project $project,Task $task,Request $request)
    {       
        Gate::authorize('archive-task', $task);

            $this->authorize('taskallow',$task);

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

        $this->authorize('taskaccess',$task);

      DB::transaction(function () use ($task) {     
        $task->delete();
        //$task->activities()->update(['is_hidden' => true]);
      });

      return $this->respondWithSuccess([
        'message' => 'Project task archived successfully',
        'members' => new TaskResource($task),
      ]);

    }

     public function unarchive(Project $project,Task $task)
     {
        $this->authorize('taskaccess',$task);

        DB::transaction(function () use ($task) { 
        $task->restore();
        //$task->activities()->update(['is_hidden' => false]);
        });

       return $this->respondWithSuccess([
        'message' => 'Project task unArchived successfully',
        'task' => new TaskResource($task),
    ]);
    }
    
    public function search(Project $project,Request $request)
    { 
        Gate::authorize('archive-task', $task);

        $this->authorize('taskaccess',$task);

       $searchTerm = $request->input('search');

       $searchResults = $project->activeMembers()
        ->select('users.id','name', 'email', 'username')
        ->where(function ($query) use ($searchTerm) {
          $query->where('name', 'like', '%' . $searchTerm . '%')
               ->orWhere('email', 'like', '%' . $searchTerm . '%')
               ->orWhere('username', 'like', '%' . $searchTerm . '%');
          })->take(5)
            ->get();

      return UsersResource::collection($searchResults);
    }

    
}


