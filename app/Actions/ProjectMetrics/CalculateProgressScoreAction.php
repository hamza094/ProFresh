<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateProgressScoreAction
{
    public function __construct(
        private GetStageProgressAction $stageProgressAction
    ) {}

    public function execute(Project $project): float
    {
        $config = config('project-metrics.progress');
        $stageProgress = $this->stageProgressAction->execute($project);
        $recentActivitiesCount = $project->recent_activities_count ?? 0;
        
        $activityScore = min($config['activity_max_score'], $recentActivitiesCount * $config['activity_multiplier']);
        
        return round(($stageProgress['percentage'] * $config['stage_weight']) + $activityScore, 1);
    }
}
