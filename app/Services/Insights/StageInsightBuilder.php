<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class StageInsightBuilder
{
    public function build(array $stageProgress): array
    {
        return match($stageProgress['status']) {
            'postponed' => [
                'type' => InsightType::WARNING->value,
                'title' => 'Project Postponed',
                'message' => "Project postponed in {$stageProgress['current_stage']} stage",
                'data' => [
                    'stage' => $stageProgress['current_stage'],
                    'percentage' => $stageProgress['percentage']
                ]
            ],
            'completed' => [
                'type' => InsightType::SUCCESS->value,
                'title' => 'Project Completed',
                'message' => "Project completed ({$stageProgress['percentage']}%)",
                'data' => [
                    'stage' => $stageProgress['current_stage'],
                    'percentage' => $stageProgress['percentage']
                ]
            ],
            'in_progress' => [
                'type' => $stageProgress['percentage'] >= 70 ? InsightType::SUCCESS->value :
                    ($stageProgress['percentage'] >= 40 ? InsightType::INFO->value : InsightType::WARNING->value),
                'title' => $stageProgress['percentage'] >= 70 ? 'Good Progress' :
                    ($stageProgress['percentage'] >= 40 ? 'Moderate Progress' : 'Early Stage'),
                'message' => "In {$stageProgress['current_stage']} stage ({$stageProgress['percentage']}% complete)",
                'data' => [
                    'stage' => $stageProgress['current_stage'],
                    'percentage' => $stageProgress['percentage']
                ]
            ],
            default => [
                'type' => InsightType::WARNING->value,
                'title' => 'Unknown Stage',
                'message' => 'Project stage status unclear',
                'data' => ['stage' => $stageProgress['current_stage'] ?? 'unknown']
            ],
        };
    }
}
