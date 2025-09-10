<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class HealthInsightBuilder
{
    private array $thresholds;

    public function __construct()
    {
        $this->thresholds = config('insights.health');
    }

    public function build(float $health): array
    {
        return match (true) {
            $health >= $this->thresholds['excellent_threshold'] => [
                'type' => InsightType::SUCCESS->value,
                'title' => 'Excellent Project Health',
                'message' => "Project health is {$health}% - performing exceptionally well",
                'data' => ['value' => $health]
            ],
            $health < $this->thresholds['critical_threshold'] => [
                'type' => InsightType::CRITICAL->value,
                'title' => 'Poor Project Health',
                'message' => "Project health is {$health}% - critically low",
                'data' => ['value' => $health]
            ],
            default => [
                'type' => InsightType::INFO->value,
                'title' => 'Project Health Status',
                'message' => "Project health is {$health}%",
                'data' => ['value' => $health]
            ],
        };
    }
}
