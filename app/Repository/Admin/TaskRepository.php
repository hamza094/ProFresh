<?php
namespace App\Repository\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Task;
use Carbon\Carbon;

class TaskRepository
{
   public function  getTasksWithFilter($request, $perPage)
   {
       return Task::with('project', 'status', 'assignee', 'owner')
            ->withTrashed()
            ->latest('created_at')
            ->when($request->input('filter') === 'active', fn ($query) => $query->whereNull('deleted_at'))
            ->when($request->input('filter') === 'trashed', fn ($query) => $query->whereNotNull('deleted_at'))
            ->when($request->search, function ($query) use ($request) {
           $query->whereHas('project', function ($subQuery) use ($request) {
           $subQuery->where('name', 'like', '%' . $request->search . '%');
          });
        })
        ->paginate($perPage);

   }
}