<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class GetUpcomingRiskAction
{
    public function execute(Project $project): array
    {
        $timePeriods = config('project-metrics.time_periods');
        
        $soonTasks = $project->tasks()->dueSoon($timePeriods['risk_assessment_hours'])->get();
        
        $lowProgressTasks = $soonTasks->filter(fn($task) => 
            !$task->activities()->where('created_at', '>=', now()->subDays($timePeriods['task_inactivity_days']))->exists()
        );

        return [
            'count' => $lowProgressTasks->count(),
            'tasks' => $lowProgressTasks->pluck('id')->toArray(),
        ];
    }
}
