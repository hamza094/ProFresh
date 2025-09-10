<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class RiskInsightBuilder
{
    public function build(array $upcomingRisk): array
    {
        return $upcomingRisk['count'] > 0
            ? [
                'type' => InsightType::WARNING->value,
                'title' => 'Upcoming Risk',
                'message' => "{$upcomingRisk['count']} tasks due soon with low progress",
                'data' => [
                    'count' => $upcomingRisk['count'],
                    'tasks' => array_slice($upcomingRisk['tasks'], 0, 3)
                ]
            ]
            : [
                'type' => InsightType::SUCCESS->value,
                'title' => 'No Immediate Risks',
                'message' => 'No tasks at risk this week',
                'data' => ['count' => 0]
            ];
    }
}
