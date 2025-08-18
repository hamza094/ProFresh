<?php

namespace App\Repository;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Project;
use App\Models\Task;
use App\Models\Stage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Activity;
use Illuminate\Support\Facades\Cache;

class DashBoardRepository
{
    
    public function getProjectStats(Request $request): array
    {
         $userId = Auth::id();
    $year = $request->get('year');
    $month = $request->get('month');

    $query = Project::leftJoin('project_members as pm', function($join) use($userId) {
        $join->on('projects.id', '=', 'pm.project_id')
             ->where('pm.user_id', $userId)
             ->where('pm.active', 1);
    })
    ->where(function($query) use ($userId) {
        $query->where('projects.user_id', $userId)
              ->orWhere('pm.user_id', $userId);
    })
    ->createdIn($year, $month);

    $result = $query->selectRaw("
    SUM(CASE 
        WHEN projects.user_id = ? AND projects.deleted_at IS NULL 
        THEN 1 ELSE 0 
    END) AS active_projects,
    SUM(CASE 
        WHEN projects.user_id = ? AND projects.deleted_at IS NOT NULL 
        THEN 1 ELSE 0 
    END) AS trashed_projects,
    SUM(CASE 
        WHEN pm.user_id IS NOT NULL AND projects.deleted_at IS NULL 
        THEN 1 ELSE 0 
    END) AS member_projects
", [$userId, $userId])
->first();

return [
    'active_projects' => (int) ($result->active_projects ?? 0),
    'trashed_projects' => (int) ($result->trashed_projects ?? 0),
    'member_projects' => (int) ($result->member_projects ?? 0),
    'total_projects' => (int) (($result->active_projects ?? 0) + ($result->trashed_projects ?? 0) + ($result->member_projects ?? 0))
];
}

    /**
     * Get user activities for a specific date range
     *
     * @param int $userId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserActivities(int $userId, Carbon $startDate, Carbon $endDate)
    {
        $cacheKey = "activities_{$userId}_{$startDate->format('Ymd')}_{$endDate->format('Ymd')}";

        return Cache::remember($cacheKey, now()->addSeconds(60), function () use ($userId, $startDate, $endDate) {
            return Activity::query()
                ->where('user_id', $userId)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with([
                    'subject',
                    'project' => function ($query) {
                        $query->withTrashed();
                    },
                    'project.stage'
                ])
                ->orderBy('created_at')
                ->get();
        });
    }

    /*public function fetchTaskStatistics(): object
    {
        $userId = Auth::id();

        return DB::table('tasks')
            ->selectRaw("
                COUNT(*) as total_tasks,
                SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) AS completed_tasks,
                SUM(CASE WHEN completed = 0 AND due_date < NOW() THEN 1 ELSE 0 END) AS overdue_tasks,
                SUM(CASE WHEN completed = 0 AND due_date >= NOW() THEN 1 ELSE 0 END) AS pending_tasks,
                AVG(CASE WHEN completed = 1 THEN DATEDIFF(updated_at, created_at) END) AS avg_completion_days
            ")
            ->where(function($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->orWhere('assignee_id', $userId);
            })
            ->first();
    }*/

    /*public function fetchProductivityMetrics(): array
    {
        $userId = Auth::id();
        $lastMonth = Carbon::now()->subMonth();

        return [
            'tasks_completed_this_month' => Task::where('user_id', $userId)
                ->where('completed', 1)
                ->where('updated_at', '>=', $lastMonth)
                ->count(),
            'projects_created_this_month' => Project::where('user_id', $userId)
                ->where('created_at', '>=', $lastMonth)
                ->count(),
            'avg_task_completion_time' => Task::where('user_id', $userId)
                ->where('completed', 1)
                ->whereNotNull('updated_at')
                ->avg(DB::raw('DATEDIFF(updated_at, created_at)')),
            'most_active_project' => $this->getMostActiveProject($userId)
        ];
    }*/

    /*private function getMostActiveProject(int $userId): ?object
    {
        return DB::table('activities')
            ->join('projects', 'activities.project_id', '=', 'projects.id')
            ->selectRaw("
                projects.name as project_name,
                COUNT(*) as activity_count
            ")
            ->where('activities.user_id', $userId)
            ->whereNull('projects.deleted_at')
            ->groupBy('projects.id', 'projects.name')
            ->orderBy('activity_count', 'desc')
            ->first();
    }*/
}
?>