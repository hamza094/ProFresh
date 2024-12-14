<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Benchmark;

class TaskRepository
{
  public function searchMembers(Request $request,Project $project,Task $task): Collection
  {
    //Check with load test

    $searchTerm = $request->input('search');   

      return $project->activeMembers()
           ->select('users.id', 'name', 'email', 'username')
           ->where(function ($query) use ($searchTerm) {
          $query->where('name', 'like', '%' . $searchTerm . '%')
           ->orWhere('email', 'like', '%' . $searchTerm . '%')
           ->orWhere('username', 'like', '%' . $searchTerm . '%');
    })
      ->where('users.id', '!=', auth()->id())
      ->leftJoin('task_user', function ($join) use ($task) {
        $join->on('users.id', '=', 'task_user.user_id')
            ->where('task_user.task_id', '=', $task->id);
    })
      ->whereNull('task_user.task_id')
      ->take(5)
      ->get();
   }

  }

?>