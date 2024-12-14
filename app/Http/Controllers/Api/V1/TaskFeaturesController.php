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
use App\Http\Resources\Api\V1\Task\TaskMemberResource;
use Illuminate\Validation\ValidationException;
use App\Rules\TaskAssigneeMember;
use Illuminate\Http\JsonResponse;

class TaskFeaturesController extends Controller
{
    use ApiResponseHelpers;

    /** Assign Task to Project Member(s)
     * 
      * This endpoint allows assigning a task to one or more members of the project.  
     * 
     * ### Authorization:
     * - Ensures the task belongs to a project
     * - Access is restricted to:
     *    - The task assigned members
     *   - The task owner.
     *   - The project owner
     * */
    public function assign(Project $project,Task $task,TaskMembersRequest $request,TaskService $service)
    {
        Gate::authorize('archive-task', $task);

       $members=$request->validated(['members']);

       DB::transaction(function () use ($task, $members, $service, $request, $project) {

       $task->assignee()->attach($members);

       $service->notifyAssignees($request,$task,$project);
       });

        $task->load('assignee');

        return response()->json([
          'message' => 'Task assigned to member Successfully',
          'taskMembers' => TaskMemberResource::collection($task->assignee)
        ],200);
    }

    /** Unassign Member from Project Task
     * 
      * This endpoint allows the removal of an assigned user from a specific task within a project. 
     * 
      * ### Authorization:
     * - Ensures the task belongs to a project
     * - Access is restricted to:
     *    - The task assigned members
     *   - The task owner.
     *   - The project owner
     * */
    public function unassign(Project $project,Task $task,Request $request)
    {       
        Gate::authorize('archive-task', $task);

        $request->validate([
        /**
         * The user to be unassigned must:
         * - Exist in the `users` table.
         * - Be a valid assignee of the given task.
         */
        'member' => ['required', 'exists:users,id', 
               new TaskAssigneeMember($task)],
        ]);

    $task->assignee()->detach($request->member);

    $user = User::find($request->member);

    return response()->json([
        'message' => 'Task member Unassigned',
        'member' => new TaskMemberResource($user),
     ],200);
    }
 
    /**
     * Archive Project Task
     * 
     * This endpoint allows authorized users to archive a specific task within a project.
     * 
     * Archiving a task marks it as no longer active but retains its data for reference purposes.
     * 
     * ### Authorization:
     - Ensures the task belongs to a project
     * - Access is restricted to:
     *   - The task owner.
     *   - The project owner
     * */ 
    public function archive(Project $project,Task $task)
    {
      Gate::authorize('archive-task', $task);

      DB::transaction(function () use ($task) {     
        $task->delete();
        $task->activities()->update(['is_hidden' => true]);
      });

       return response()->json([
         'message' => 'Project task archived successfully',
         'task' => new TaskResource($task),
     ],200);
    }

     /**
     * Unarchive Project Task
     * 
     * This endpoint allows authorized users to unarchive a specific task within a project.
     * 
     * Unarchiving a task marks it as active, allowing task actions to be performed.
     * 
     * ### Authorization:
     - Ensures the task belongs to a project
     * - Access is restricted to:
     *   - The task owner.
     *   - The project owner.
     * */
     public function unarchive(Project $project,Task $task)
     {
        DB::transaction(function () use ($task) { 
        $task->restore();
        $task->activities()->update(['is_hidden' => false]);
        });

       return response()->json([
         'message' => 'Project task unArchived successfully',
        'task' => new TaskResource($task),
     ],200);        
    }

    /** Search Members
     * 
      * Search through project active members 
     * 
      * ### Authorization:
     * - Ensures the task belongs to a project
     * - Access is restricted to:
     *    - The task assigned members
     *   - The task owner.
     *   - The project owner
     * */
    public function search(Project $project,Task $task,Request $request,TaskRepository $repository)
    { 
      $searchResults = $repository->searchMembers($request,$project,$task);

      return TaskMemberResource::collection($searchResults);
    }
}


