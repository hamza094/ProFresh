<?php

namespace App\Repository;

use App\Actions\ProjectMetrics\ProjectHealthMetricAction;
use App\Actions\ProjectMetrics\StageProgressMetricAction;
use App\Actions\ProjectMetrics\TaskHealthMetricAction;
use App\Actions\ProjectMetrics\TeamCollaborationMetricAction;
use App\Actions\ProjectMetrics\UpcomingRiskMetricAction;
use App\Data\ProjectMetricsDto;
use App\Models\Project;
use App\Services\ProjectInsightsPreloader;

class ProjectInsightsRepository
{
    // No class constants; defaults live in config/insights.php

    public function __construct(
        private ProjectHealthMetricAction $projectHealthAction,
        private TaskHealthMetricAction $taskHealthAction,
        private StageProgressMetricAction $stageProgressAction,
        private UpcomingRiskMetricAction $upcomingRiskAction,
        private TeamCollaborationMetricAction $collaborationHealthAction,
        private ProjectInsightsPreloader $preloader
    ) {}

    /**
     * @param  array<string>  $sections
     */
    public function getProjectInsights(Project $project, array $sections = ['all']): ProjectMetricsDto
    {
        // Preload counts for requested sections to avoid N+1 and ensure consistent metrics
        $this->preloader->preload($project, $sections);

        $actions = [
            'health' => fn () => $this->projectHealthAction->execute($project),
            'task-health' => fn () => $this->taskHealthAction->execute($project),
            'risk' => fn () => $this->upcomingRiskAction->execute($project),
            'stage' => fn () => $this->stageProgressAction->execute($project),
            'collaboration' => fn () => $this->collaborationHealthAction->execute($project),
        ];

        $results = collect($actions)
            ->map(fn ($closure, $section) => $this->shouldInclude($section, $sections) ? $closure() : null)
            ->values()
            ->all();

        return new ProjectMetricsDto(...$results);
    }

    /**
     * Load all required counts in a single optimized query
     */
    /**
     * @param  Project  $project
     * @param  array<string>  $sections
     */

    /**
     * Check if a section should be included in the response
     *
     * @param  array<string>  $sections
     */
    private function shouldInclude(string $section, array $sections): bool
    {
        return in_array('all', $sections) || in_array($section, $sections);
    }
}
