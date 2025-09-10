<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class OverdueInsightBuilder
{
    public function build(int $overdueCount, array $thresholds): array
    {
        return $overdueCount > 0
            ? [
                'type' => InsightType::WARNING->value,
                'title' => 'Overdue Tasks',
                'message' => "{$overdueCount} tasks are overdue",
                'data' => ['count' => $overdueCount]
            ]
            : [
                'type' => InsightType::SUCCESS->value,
                'title' => 'No Overdue Tasks',
                'message' => 'All tasks are on track',
                'data' => ['count' => 0]
            ];
    }
}
