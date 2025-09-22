<?php

namespace App\Data;

final class ProjectMetricsDto
{
    public function __construct(
        public readonly ?float $health,
        public readonly ?float $taskHealth,
        public readonly ?array $upcomingRisk,
        public readonly ?array $stageProgress,
        public readonly ?float $collaborationScore,
        public readonly ?float $progressScore,
    ) {}
}
