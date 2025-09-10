<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateTaskHealthAction
{
    public function execute(Project $project): float
    {
        $tasksCount = $project->tasks_count ?? 0;
        $completedCount = $project->completed_tasks_count ?? 0;
        $overdueCount = $project->overdue_tasks_count ?? 0;
        
        if ($tasksCount === 0) return 0.0;
        
        $overduePenaltyMultiplier = config('project-metrics.health.task_health.overdue_penalty_multiplier', 40);
        
        $completionRate = ($completedCount / $tasksCount) * 100;
        $overduePenalty = ($overdueCount / $tasksCount) * $overduePenaltyMultiplier;
        
        return max(0, min(100, $completionRate - $overduePenalty));
    }
}
