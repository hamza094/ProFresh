<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class ThresholdInsightBuilder
{
    public function build(
        float $value,
        string $metricName,
        array $thresholds,
        array $messages
    ): array {
        return match (true) {
            $value >= $thresholds['high'] => [
                'type' => InsightType::SUCCESS->value,
                'title' => $messages['high']['title'],
                'message' => sprintf($messages['high']['message'], $value),
                'data' => ['value' => $value]
            ],
            $value < $thresholds['low'] => [
                'type' => InsightType::WARNING->value,
                'title' => $messages['low']['title'],
                'message' => sprintf($messages['low']['message'], $value),
                'data' => ['value' => $value]
            ],
            default => [
                'type' => InsightType::INFO->value,
                'title' => $messages['normal']['title'],
                'message' => sprintf($messages['normal']['message'], $value),
                'data' => ['value' => $value]
            ],
        };
    }
}
