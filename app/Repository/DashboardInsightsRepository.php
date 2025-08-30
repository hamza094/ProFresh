<?php

namespace App\Repository;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;


class DashboardInsightsRepository
{
    // Note: Assembly of KPIs and insights moved to service layer.

    public function getUserProjects(int $userId): Collection
    {
        return Project::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->orWhereHas('activeMembers', function ($memberQuery) use ($userId) {
                      $memberQuery->where('user_id', $userId);
                  });
        })
        ->select(['id'])
        ->get();
    }


    public function getTaskCompletionRate(int $userId): float
    {
        $baseQuery = $this->baseUserTasks($userId);
        $totalTasks = $baseQuery->count();

        if ($totalTasks === 0) {
            return 100.0;
        }

        $completedTasks = (clone $baseQuery)->completed()->count();

        return round(($completedTasks / $totalTasks) * 100, 1);
    }

    public function getOverdueTasksCount(int $userId): int
    {
        return $this->baseUserTasks($userId)
            ->overdue()
            ->count();
    }

    public function getCriticalProjectsCount(Collection $projects): int
    {
        $threshold = (int) config('dashboard.insights.critical_project.overdue_threshold', 3);
        
        if ($projects->isEmpty()) {
            return 0;
        }
        
        // Single query to get overdue counts for all projects (fixes N+1)
        $projectIds = $projects->pluck('id');
        if ($projectIds->isEmpty()) {
            return 0;
        }

        $overdueCounts = Task::selectRaw('project_id, COUNT(*) as overdue_count')
            ->whereIn('project_id', $projectIds)
            ->overdue()
            ->groupBy('project_id')
            ->pluck('overdue_count', 'project_id');

        return $projects->sum(function ($project) use ($threshold, $overdueCounts) {
            return ($overdueCounts[$project->id] ?? 0) > $threshold ? 1 : 0;
        });
    }

    // Status evaluation moved to service layer.

    /**
     * Base tasks query limited to projects the user created OR is a member of
     */
    private function baseUserTasks(int $userId): Builder
    {
        // Optimized with joins instead of nested whereHas for better performance
        return Task::join('projects', 'tasks.project_id', '=', 'projects.id')
            ->leftJoin('project_members', function($join) {
                $join->on('projects.id', '=', 'project_members.project_id')
                     ->where('project_members.active', 1);
            })
            ->where(function ($query) use ($userId) {
                $query->where('projects.user_id', $userId)
                      ->orWhere('project_members.user_id', $userId);
            })
            ->select('tasks.*')
            ->distinct();
    }
}
