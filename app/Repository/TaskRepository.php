<?php
namespace App\Repository;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TaskRepository
{
  public function searchMembers(Request $request,Project $project): Collection
  {
    $searchTerm = $request->input('search');   

    return $project->activeMembers()
           ->select('users.id','name', 'email', 'username')
           ->where(function ($query) use ($searchTerm) {
              $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%')
                ->orWhere('username', 'like', '%' . $searchTerm . '%');
              })->where('users.id', '!=', auth()->user()->id)
              ->take(5)
              ->get();
    }
  }

?>