<?php

namespace App\Services\Api\V1;

use App\Models\Project;
use App\Repository\ProjectInsightsRepository;
use App\Data\ProjectMetricsDto;
use App\Services\Insights\HealthInsightBuilder;
use App\Services\Insights\ThresholdInsightBuilder;
use App\Services\Insights\RiskInsightBuilder;
use App\Services\Insights\StageInsightBuilder;
use App\Services\Insights\OverdueInsightBuilder;
use App\Services\Insights\CompletionInsightBuilder;
use App\Services\Insights\ProgressInsightBuilder;

final class ProjectInsightService
{
    private array $insightBuilders;

    public function __construct(
        private ProjectInsightsRepository $repository,
        private HealthInsightBuilder $healthBuilder,
        private ThresholdInsightBuilder $thresholdBuilder,
        private RiskInsightBuilder $riskBuilder,
        private StageInsightBuilder $stageBuilder,
        private OverdueInsightBuilder $overdueBuilder,
        private CompletionInsightBuilder $completionBuilder,
        private ProgressInsightBuilder $progressBuilder,
    ) {
        $this->setupBuilders();
    }

    /**
     * Setup insight builders mapping
     */
    private function setupBuilders(): void
    {
        $this->insightBuilders = [
            'completion' => fn(ProjectMetricsDto $m) => $this->completionBuilder->build($m->completionRate),
            'health' => fn(ProjectMetricsDto $m) => $this->healthBuilder->build($m->health),
            'overdue' => fn(ProjectMetricsDto $m) => $this->overdueBuilder->build($m->overdueCount, config('insights.overdue')),
            'engagement' => fn(ProjectMetricsDto $m) => $this->thresholdBuilder->build(
                $m->teamEngagement,
                'engagement',
                config('insights.engagement.thresholds'),
                config('insights.engagement.messages')
            ),
            'collaboration' => fn(ProjectMetricsDto $m) => $this->thresholdBuilder->build(
                $m->collaborationScore,
                'collaboration',
                config('insights.collaboration.thresholds'),
                config('insights.collaboration.messages')
            ),
            'risk' => fn(ProjectMetricsDto $m) => $this->riskBuilder->build($m->upcomingRisk),
            'stage' => fn(ProjectMetricsDto $m) => $this->stageBuilder->build($m->stageProgress),
            'progress' => fn(ProjectMetricsDto $m) => $this->progressBuilder->build($m->progressScore),
        ];
    }

    /**
     * Get comprehensive project insights with actionable recommendations
     */
    public function getInsights(Project $project, int $userId, array $sections = ['all']): array
    {
        $metrics = $this->repository->getProjectInsights($project, $sections);
        return $this->buildInsights($metrics, $sections);
    }

    /**
     * Generate actionable insights based on project data
     */
    private function buildInsights(ProjectMetricsDto $metrics, array $sections): array
    {
        return collect($this->insightBuilders)
            ->filter(fn($builder, $section) => $this->shouldIncludeInsight($section, $sections))
            ->filter(fn($builder, $section) => $this->hasData($metrics, $section))
            ->map(fn($builder) => $builder($metrics))
            ->values()
            ->toArray();
    }

    /**
     * Check if insight should be included based on sections
     */
    private function shouldIncludeInsight(string $section, array $sections): bool
    {
        return in_array('all', $sections) || in_array($section, $sections);
    }

    /**
     * Check if metrics has data for the given section
     */
    private function hasData(ProjectMetricsDto $metrics, string $section): bool
    {
        return match($section) {
            'completion' => $metrics->completionRate !== null,
            'health' => $metrics->health !== null,
            'overdue' => $metrics->overdueCount !== null,
            'engagement' => $metrics->teamEngagement !== null,
            'collaboration' => $metrics->collaborationScore !== null,
            'risk' => $metrics->upcomingRisk !== null,
            'stage' => $metrics->stageProgress !== null,
            'progress' => $metrics->progressScore !== null,
            default => false,
        };
    }
}
