<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class CompletionInsightBuilder
{
    public function build(float $completionRate): array
    {
        return [
            'type' => InsightType::INFO->value,
            'title' => 'Project Completion',
            'message' => "Project completion rate is {$completionRate}%",
            'data' => ['value' => $completionRate]
        ];
    }
}
