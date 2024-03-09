<?php
namespace App\Repository;

use App\Models\Task;

class UserTasksDataRepository
{
    public function getTasks($userId, $request)
    {
       return Task::where(function ($query) use ($userId,$request) {
      $this->applyUserCreatedFilter($query, $userId, $request);
      $this->applyTaskAssignedFilter($query, $userId, $request);
    })
   ->when($request->completed, fn ($query)=> 
       $query->where('user_id', $userId)->completed())

    ->when($request->overdue, fn ($query) =>
        $query->where('user_id', $userId)->overdue())

   ->when($request->remaining, fn ($query)=> 
        $query->where('user_id', $userId)->remaining())

    ->with(['project' => fn ($q) => $q->withTrashed(), 'status', 'assignee'])
    ->get();

    }

    protected function applyUserCreatedFilter($query, $userId, $request)
   {
     if ($request->user_created) {
         $query->where('user_id', $userId);
     }
   }

   protected function applyTaskAssignedFilter($query, $userId, $request)
   {
     if ($request->task_assigned) {
        $query->orWhereHas('assignee', fn ($subquery) => $subquery->where('users.id', $userId));
    }
   }

   public function appliedFilters($request)
   {
    return collect([
        'user_created' => 'Filter by Created',
        'task_assigned' => 'Filter by Assigned',
        'completed' => 'Filter by Completed',
        'overdue' => 'Filter by Overdue',
        'remaining' => 'Filter by Remaining',
    ])->only(array_keys($request->all()))
        ->values()->toArray();
    }



 }

?>