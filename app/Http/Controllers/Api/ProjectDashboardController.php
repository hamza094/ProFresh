<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserActivitiesResource;
use App\Services\DashboardService;
use App\Http\Resources\ProjectsResource;
use App\Http\Resources\UserTasksResource;
use Carbon\Carbon;

class ProjectDashboardController extends Controller
{
    private $DashboardService;

    public function __construct(DashboardService $dashboardService)
    {
       $this->dashboardService=$dashboardService;
    }

    public function userprojects()
    {
       return $this->dashboardService->getUserProjects();
    }

    public function activities()
    {
        $activities = Activity::query()
         ->where('user_id', auth()->id())
         ->with(['subject', 'project' => function ($query) {
              $query->withTrashed();
           }, 'project.stage'])
        ->get();

        return UserActivitiesResource::collection($activities);       
    }

    public function data(Request $request)
    {     
      $data = [];

     $data = $this->dashboardService->fetchData();

      return response()->json(['projectsData'=>$data]);
    }

    public function tasksData(Request $request)
    {
        $userId=auth()->id();

        $tasks = Task::where(function ($query) use ($userId,$request) {
    if ($request->user_created){
        $query->where('user_id', $userId);
    }
       if ($request->task_assigned) {
        $query->orWhereHas('assignee', function ($subquery) use ($userId) {
            $subquery->where('users.id', $userId);
        });
    }
    })
   ->when($request->completed, fn ($query)=> 
       $query->where('user_id', $userId)->completed())

    ->when($request->overdue, fn ($query) =>
        $query->where('user_id', $userId)->overdue())

   ->when($request->remaining, fn ($query)=> 
        $query->where('user_id', $userId)->remaining())

    ->with(['project' => fn ($q) => $q->withTrashed(), 'status', 'assignee'])
    ->get();

      $appliedFilters = collect([
        'user_created' => 'Filter by Created',
        'task_assigned' => 'Filter by Assigned',
        'completed' => 'Filter by Completed',
        'overdue' => 'Filter by Overdue',
        'remaining' => 'Filter by Remaining',
    ])->only(array_keys($request->all()))
       ->values()->toArray();

    return [
        'tasks' => UserTasksResource::collection($tasks),
        'applied_filters' => $appliedFilters,
    ];

    }

}
