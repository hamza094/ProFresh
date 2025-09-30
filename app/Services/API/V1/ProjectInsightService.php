<?php

namespace App\Services\Api\V1;

use App\Models\Project;
use App\Repository\ProjectInsightsRepository;
use App\Data\ProjectMetricsDto;
use App\Actions\ProjectMetrics\TaskHealthMetricAction;
use App\Services\Insights\HealthInsightBuilder;
use App\Services\Insights\TaskHealthInsightBuilder;
use App\Services\Insights\TeamCollaborationInsightBuilder;
use App\Services\Insights\RiskInsightBuilder;
use App\Services\Insights\StageInsightBuilder;
use App\Actions\ProjectMetrics\CommunicationHealthMetricAction;
use App\Actions\ProjectMetrics\ActivityHealthMetricAction;

final class ProjectInsightService
{
    /**
     * @var array<string, callable(ProjectMetricsDto, ?Project): mixed>
     */
    private array $insightBuilders;

    public function __construct(
        private ProjectInsightsRepository $repository,
        private TaskHealthMetricAction $taskHealthAction,
        private CommunicationHealthMetricAction $communicationHealthAction,
        private ActivityHealthMetricAction $activityHealthAction,
        private HealthInsightBuilder $healthBuilder,
        private TaskHealthInsightBuilder $taskHealthBuilder,
        private TeamCollaborationInsightBuilder $collaborationBuilder,
        private RiskInsightBuilder $riskBuilder,
        private StageInsightBuilder $stageBuilder,
    ) {
        $this->setupBuilders();
    }

    /**
     * Setup insight builders mapping
     */
    private function setupBuilders(): void
    {
        // Each builder receives the metrics DTO and an optional Project instance
        $this->insightBuilders = [
            'health' => fn(ProjectMetricsDto $m, ?Project $project = null) => $this->healthBuilder->build($m->health),

            'task-health' => fn(ProjectMetricsDto $m, ?Project $project = null) => $this->taskHealthBuilder->build(
                $m->taskHealth,
                $project ? ['summary' => $this->taskHealthAction->summary($project)] : []
            ),
            'collaboration' => fn(ProjectMetricsDto $m, ?Project $project = null) => $this->collaborationBuilder->build(
                $m->collaborationScore,
                ['details' => $this->getCollaborationDetails($project)]
            ),
            'risk' => fn(ProjectMetricsDto $m, ?Project $project = null) => $this->riskBuilder->build($m->upcomingRisk),
            'stage' => fn(ProjectMetricsDto $m, ?Project $project = null) => $this->stageBuilder->build($m->stageProgress),
        ];
    }

    /**
     * Get comprehensive project insights with actionable recommendations
     *
     * @param Project $project
     * @param array<string> $sections
     * @return array
     */
    public function getInsights(Project $project, array $sections = []): array
    {
        if (empty($sections)) {
            $sections = array_keys($this->insightBuilders);
        }

        $metrics = $this->repository->getProjectInsights($project, $sections);
        return $this->buildInsights($metrics, $sections, $project);
    }

    /**
     * Generate actionable insights based on project data
     *
     * @param ProjectMetricsDto $metrics
     * @param array<string> $sections
     * @param Project|null $project
     * @return array
     */
    private function buildInsights(ProjectMetricsDto $metrics, array $sections, ?Project $project = null): array
    {
        return collect($this->insightBuilders)
            ->filter(fn($builder, $section) => $this->shouldIncludeInsight($section, $sections))
            ->filter(fn($builder, $section) => $this->hasData($metrics, $section))
            ->map(fn($builder) => $builder($metrics, $project))
            ->values()
            ->toArray();
    }

    /**
     * Check if insight should be included based on sections
     */
    private function shouldIncludeInsight(string $section, array $sections): bool
    {
        return in_array($section, $sections, true);
    }

    /**
     * Check if metrics has data for the given section
     */
    private function hasData(ProjectMetricsDto $metrics, string $section): bool
    {
        return match($section) {
            'health' => $metrics->health !== null,
            'task-health' => $metrics->taskHealth !== null,
            'collaboration' => $metrics->collaborationScore !== null,
            'risk' => $metrics->upcomingRisk !== null,
            'stage' => $metrics->stageProgress !== null,
            default => false,
        };
    }

    /**
     * Extract collaboration details from project for insight building
     */
    private function getCollaborationDetails(?Project $project): array
    {
        if (!$project) {
            return [];
        }

        return [
            'member_count' => max(0, (int) ($project->active_members_count ?? 0)),
            'meeting_count' => max(0, (int) ($project->recent_meetings_count ?? 0)),
            'participant_count' => max(0, (int) ($project->recent_participants_count ?? 0)),
        ];
    }
}
