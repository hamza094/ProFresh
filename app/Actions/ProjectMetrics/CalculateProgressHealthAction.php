<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateProgressHealthAction
{
    public function execute(Project $project, array $stageProgress): float
    {
        if ($stageProgress['status'] === 'postponed') return 0;
        
        $config = config('project-metrics.progress');
        $recentActivitiesCount = $project->recent_activities_count ?? 0;
        
        $stageScore = $stageProgress['percentage'] * $config['stage_weight'];
        $activityScore = min($config['activity_max_score'], $recentActivitiesCount * $config['activity_multiplier']);
        
        return round($stageScore + $activityScore, 1);
    }
}
