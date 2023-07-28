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
use F9Web\ApiResponseHelpers;
use App\Http\Resources\UsersResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class TaskFeaturesController extends Controller
{
    use ApiResponseHelpers;

    public function members(Project $project,Task $task,TaskMembersRequest $request)
    {
        $members=$request->members;


       $existingMembers = $task->assignee()->whereIn('user_id',$members)->count();
       

  throw_if($existingMembers > 0,
      ValidationException::withMessages(
        ['members'=>'One or more users are already assigned to the task.'])
      );

     $task->assignee()->syncWithoutDetaching($members);

    /*$task->assignee->each->notify(new TaskAssigned($task, $project, auth()->user()));*/

    return $this->respondWithSuccess([
        'message' => 'Task assigned to member Successfully',
        'taskMembers' =>  UsersResource::collection($task->assignee),
    ]);
    }

    public function unassign(Project $project,Task $task,Request $request)
    {       
        $request->validate([
            'member' => 'required|exists:users,id',
        ]);

    $task->assignee()->detach($request->member);

    return $this->respondWithSuccess([
        'message' => 'Task member Unassigned',
        'members' => UsersResource::collection($task->assignee),
    ]);
    }

    public function search(Project $project,Request $request)
    {
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


