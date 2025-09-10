<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class CalculateProjectHealthAction
{
    public function __construct(
        private CalculateTaskHealthAction $taskHealthAction,
        private CalculateCommunicationHealthAction $communicationHealthAction,
        private CalculateCollaborationHealthAction $collaborationHealthAction,
        private CalculateProgressHealthAction $progressHealthAction,
        private GetStageProgressAction $stageProgressAction
    ) {}

    public function execute(Project $project): float
    {
        $weights = config('project-metrics.health.weights');
        
        $taskHealth = $this->taskHealthAction->execute($project);
        $communicationHealth = $this->communicationHealthAction->execute($project);
        $collaborationHealth = $this->collaborationHealthAction->execute($project);
        $stageProgress = $this->stageProgressAction->execute($project);
        $progressHealth = $this->progressHealthAction->execute($project, $stageProgress);

        return round(
            ($taskHealth * $weights['tasks']) + 
            ($communicationHealth * $weights['communication']) + 
            ($collaborationHealth * $weights['collaboration']) + 
            ($progressHealth * $weights['progress']), 1
        );
    }
}
