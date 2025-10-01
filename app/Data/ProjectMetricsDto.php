<?php

namespace App\Data;

final class ProjectMetricsDto
{
    /**
     * Data transfer object for project metrics.
     *
     * Each property may be null when that section was not requested or when
     * the metric could not be computed. Callers should handle nulls.
     *
    * @param float|null $health Overall project health score (0-100)
     * @param float|null $taskHealth Task health score (0-100)
     * @param array<string,mixed>|null $upcomingRisk Risk details (keys: score, at_risk_count, due_soon_count)
     * @param array<string,mixed>|null $stageProgress Stage progress details (keys: percentage, current_stage, status, stage_id)
     * @param float|null $collaborationScore Collaboration score (0-100)
     */
    public function __construct(
        public readonly ?float $health = null,
        public readonly ?float $taskHealth = null,
        public readonly ?array $upcomingRisk = null,
        public readonly ?array $stageProgress = null,
        public readonly ?float $collaborationScore = null,
    ) {}
}
