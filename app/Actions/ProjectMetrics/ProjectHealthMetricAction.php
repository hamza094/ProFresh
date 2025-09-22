<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class ProjectHealthMetricAction
{
    private const DEFAULT_COMMUNICATION_SCORE_PER_CONVERSATION = 10.0;
    private const DEFAULT_COMMUNICATION_MAX_SCORE = 100.0;
    private const DEFAULT_ACTIVITY_COUNT_FOR_FULL = 15;
    private const DEFAULT_WEIGHT_TASKS = 0.3;
    private const DEFAULT_WEIGHT_COMMUNICATION = 0.2;
    private const DEFAULT_WEIGHT_COLLABORATION = 0.2;
    private const DEFAULT_WEIGHT_STAGE = 0.15;
    private const DEFAULT_WEIGHT_ACTIVITY = 0.15;

    public function __construct(
        private TaskHealthMetricAction $taskHealthAction,
        private TeamCollaborationMetricAction $collaborationHealthAction,
        private StageProgressMetricAction $stageProgressAction
    ) {}

    public function execute(Project $project): float
    {
        $weights = $this->getHealthWeights();
        
        $taskHealth = $this->taskHealthAction->execute($project);
        $communicationHealth = $this->calculateCommunicationHealth($project);
        $collaborationHealth = $this->collaborationHealthAction->execute($project);
        $stagePercentage = $this->calculateStagePercentage($project);
        $activityPercentage = $this->calculateActivityPercentage($project);

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
        $configWeights = config('project-metrics.health.weights', []);
        
        return [
            'tasks' => (float) ($configWeights['tasks'] ?? self::DEFAULT_WEIGHT_TASKS),
            'communication' => (float) ($configWeights['communication'] ?? self::DEFAULT_WEIGHT_COMMUNICATION),
            'collaboration' => (float) ($configWeights['collaboration'] ?? self::DEFAULT_WEIGHT_COLLABORATION),
            'stage' => (float) ($configWeights['stage'] ?? self::DEFAULT_WEIGHT_STAGE),
            'activity' => (float) ($configWeights['activity'] ?? self::DEFAULT_WEIGHT_ACTIVITY),
        ];
    }

    private function calculateCommunicationHealth(Project $project): float
    {
        $conversationCount = max(0, (int) ($project->recent_conversations_count ?? 0));
        
        $scorePerConversation = config(
            'project-metrics.health.communication.score_per_conversation', 
            self::DEFAULT_COMMUNICATION_SCORE_PER_CONVERSATION
        );
        $maxScore = config(
            'project-metrics.health.communication.max_score', 
            self::DEFAULT_COMMUNICATION_MAX_SCORE
        );

        return min($maxScore, $conversationCount * $scorePerConversation);
    }

    private function calculateStagePercentage(Project $project): float
    {
        $stageData = $this->stageProgressAction->execute($project);
        $percentage = $stageData['percentage'] ?? 0;
        
        return $this->normalizePercentage($percentage);
    }

    private function calculateActivityPercentage(Project $project): float
    {
        $activityCount = max(0, (int) ($project->recent_activities_count ?? 0));
        
        $fullActivityCount = config(
            'project-metrics.progress.activity_count_for_full', 
            self::DEFAULT_ACTIVITY_COUNT_FOR_FULL
        );

        if ($fullActivityCount <= 0) {
            return 0.0;
        }

        $percentage = ($activityCount / $fullActivityCount) * 100.0;
        
        return $this->normalizePercentage($percentage);
    }

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
