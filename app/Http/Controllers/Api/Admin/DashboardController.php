<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\Admin\ActivitiesResource;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use App\Services\Admin\DashboardService;


class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function backup()
    {
       try {
               Artisan::call('backup:clean');
            Artisan::call('backup:run');
            return response()->json(['message' => 'Backup process started']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function activities()
    {
        $activities=Activity::with('user','subject','project')->latest()->limit(15)->get();

        return ActivitiesResource::collection($activities);
    }

   public function data(Request $request)
   {     
    $data = [];

    $startDate = Carbon::now()->subMonths(11)->startOfMonth();
    $endDate = Carbon::now()->endOfMonth();

    $data = $this->dashboardService->fetchDataForMonths($startDate, $endDate);

    /*$projectsDataByMonth = DB::table('projects')
      ->selectRaw('
         DATE_FORMAT(created_at, ?) as month,
         COUNT(*) as total_projects,
         SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) AS active_projects,
         SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) AS trashed_projects
         ',['%Y-%m'])
     ->whereBetween('created_at', [$startDate, $endDate])
     ->groupBy('month')
     ->orderBy('month')
     ->get();*/

    /*foreach ($projectsDataByMonth as $project) {
            $data[] = [
                'month' => $project->month,
                'projects_count'=>$project->total_projects,
                'active_projects' => $project->active_projects,
                'trashed_projects' => $project->trashed_projects,
                'tasks_count'=>0,
                'active_tasks' => 0,
                'trashed_tasks' => 0,
            ];
        }*/

    /*$tasksDataByMonth = DB::table('tasks')
     ->selectRaw('
        DATE_FORMAT(created_at, ?) as month,
        COUNT(*) as total_tasks,
        SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) AS active_tasks,
        SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) AS trashed_tasks
    ',['%Y-%m'])
    ->whereBetween('created_at', [$startDate, $endDate])
    ->groupBy('month')
    ->orderBy('month')
    ->get();*/

     /*foreach ($tasksDataByMonth as $task) {
            $monthIndex = array_search($task->month, array_column($data, 'month'));
            if ($monthIndex !== false) {
                $data[$monthIndex]['active_tasks'] = $task->active_tasks;
                $data[$monthIndex]['trashed_tasks'] = $task->trashed_tasks;
                $data[$monthIndex]['tasks_count'] = $task->total_tasks; 
            } else {
                $data[] = [
                    'month' => $task->month,
                    'active_projects' => 0,
                    'trashed_projects' => 0,
                    'tasks_count' => $task->total_tasks,
                    'active_tasks' => $task->active_tasks,
                    'trashed_tasks' => $task->trashed_tasks,
                ];
            }
        }*/

      return response()->json($data);
    }
}
