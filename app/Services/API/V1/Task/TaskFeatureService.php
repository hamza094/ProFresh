<?php
declare(strict_types=1);

namespace App\Services\Api\V1\Task;

use Illuminate\Http\Request;
use App\Actions\NotificationAction;
use Illuminate\Support\Facades\Gate;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Auth;
use App\Notifications\ProjectTask;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Notification;

class TaskFeatureService
{ 

   public function assignMembers(Task $task, array $members, Project $project): void
    {
      DB::transaction(function () use ($task, $members, $project) {
            $task->assignee()->attach($members);
            $this->notifyAssignees($members,$task, $project);
        });

        $task->load('assignee');
    }

  private function notifyAssignees($members, Task $task, Project $project)
  {
    $usersToNotify = User::whereIn('id', $members)
    ->where('id', '!=', Auth::id())
    ->select('id', 'name', 'email')
    ->get();

    Notification::send($usersToNotify, new TaskAssigned($task->title, $project, auth()->user()));
  }

    public function archiveTask(Task $task): void
    {
        DB::transaction(function () use ($task) {
            $task->delete();
            $task->activities()->update(['is_hidden' => true]);
        });

    }

      public function unarchiveTask(Task $task): void
    {
        if (!$task->trashed()) {
            abort(403, 'Task must be trashed to perform this action');
        }

        DB::transaction(function () use ($task) {
            $task->restore();
            $task->activities()->update(['is_hidden' => false]);
        });
    }    

  public function removeTask(Task $task): void
  {
     DB::transaction(function () use ($task) { 
     $task->activities()->delete();
     $task->forceDelete();
     });
  }  
}