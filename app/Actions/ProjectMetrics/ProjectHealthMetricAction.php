<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

/**
 * Composite Project Health calculation.
 *
 * Components (each expected 0–100):
 * - tasks: TaskHealthMetricAction
 * - communication: CommunicationHealthMetricAction
 * - collaboration: TeamCollaborationMetricAction
 * - stage: StageProgressMetricAction (percentage only)
 * - activity: ActivityHealthMetricAction
 *
 * Weights are read from config('project-metrics.health.weights').
 */
class ProjectHealthMetricAction
{
    public function __construct(
        private TaskHealthMetricAction $taskHealthAction,
        private TeamCollaborationMetricAction $collaborationHealthAction,
        private StageProgressMetricAction $stageProgressAction,
        private CommunicationHealthMetricAction $communicationHealthAction,
        private ActivityHealthMetricAction $activityHealthAction
    ) {}

    public function execute(Project $project): float
    {
        $weights = $this->getHealthWeights();
        
        $taskHealth = $this->taskHealthAction->execute($project);
        $communicationHealth = $this->communicationHealthAction->execute($project);
        $collaborationHealth = $this->collaborationHealthAction->execute($project);
        $stagePercentage = $this->calculateStagePercentage($project);
        $activityPercentage = $this->activityHealthAction->execute($project);

        // Calculate final composite weighted health score
        $weightedScore = 
            ($taskHealth * $weights['tasks']) + 
            ($communicationHealth * $weights['communication']) + 
            ($collaborationHealth * $weights['collaboration']) + 
            ($stagePercentage * $weights['stage']) +
            ($activityPercentage * $weights['activity']);

        return $this->normalizeScore($weightedScore);
    }

    private function getHealthWeights(): array
    {
        $weights = (array) config('project-metrics.health.weights', []);

        return [
            'tasks' => (float) ($weights['tasks'] ?? 0.0),
            'communication' => (float) ($weights['communication'] ?? 0.0),
            'collaboration' => (float) ($weights['collaboration'] ?? 0.0),
            'stage' => (float) ($weights['stage'] ?? 0.0),
            'activity' => (float) ($weights['activity'] ?? 0.0),
        ];
    }

    // Communication calculation moved to CommunicationHealthMetricAction

    private function calculateStagePercentage(Project $project): float
    {
        $stageData = $this->stageProgressAction->execute($project);
        $percentage = $stageData['percentage'] ?? 0;
        
        return $this->normalizePercentage($percentage);
    }

    // Activity calculation moved to ActivityHealthMetricAction

    private function normalizePercentage(float|int $value): float
    {
        if (!is_numeric($value)) {
            return 0.0;
        }

        return max(0.0, min(100.0, (float) $value));
    }

    private function normalizeScore(float $score): float
    {
        return round(max(0.0, min(100.0, $score)), 1);
    }
}
