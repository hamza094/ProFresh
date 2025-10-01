<?php
namespace App\Repository;

use App\Models\Project;
use App\Data\ProjectMetricsDto;
use App\Actions\ProjectMetrics\ProjectHealthMetricAction;
use App\Actions\ProjectMetrics\TaskHealthMetricAction;
use App\Actions\ProjectMetrics\StageProgressMetricAction;
use App\Actions\ProjectMetrics\UpcomingRiskMetricAction;
use App\Actions\ProjectMetrics\TeamCollaborationMetricAction;
use Carbon\CarbonInterface;

class ProjectInsightsRepository
{
    // No class constants; defaults live in config/insights.php

    /**
     * @param ProjectHealthMetricAction $projectHealthAction
     * @param TaskHealthMetricAction $taskHealthAction
     * @param StageProgressMetricAction $stageProgressAction
     * @param UpcomingRiskMetricAction $upcomingRiskAction
     * @param TeamCollaborationMetricAction $collaborationHealthAction
     */
    public function __construct(
        private ProjectHealthMetricAction $projectHealthAction,
        private TaskHealthMetricAction $taskHealthAction,
        private StageProgressMetricAction $stageProgressAction,
        private UpcomingRiskMetricAction $upcomingRiskAction,
        private TeamCollaborationMetricAction $collaborationHealthAction
    ) {}
    /**
     * @param Project $project
     * @param array<string> $sections
     */
    public function getProjectInsights(Project $project, array $sections = ['all']): ProjectMetricsDto
    {
        // Load all required counts in a single optimized query
        $this->loadAllRequiredCounts($project, $sections);
        

        $actions = [
            'health' => fn() => $this->projectHealthAction->execute($project),
            'task-health' => fn() => $this->taskHealthAction->execute($project),
            'risk' => fn() => $this->upcomingRiskAction->execute($project),
            'stage' => fn() => $this->stageProgressAction->execute($project),
            'collaboration' => fn() => $this->collaborationHealthAction->execute($project),
        ];

        $results = collect($actions)
                    ->map(fn($closure, $section) => $this->shouldInclude($section, $sections) ? $closure() : null)
                    ->values()
                    ->all();

        return new ProjectMetricsDto(...$results);
    }

    /**
     * Load all required counts in a single optimized query
     */
    /**
     * @param Project $project
     * @param array<string> $sections
     */
    private function loadAllRequiredCounts(Project $project, array $sections): void
    {
        // Capture a single timestamp for consistent time windows across all queries
        $now = now();

        // Build counts map using the captured timestamp
        $countsToLoad = $this->buildCountsMap($sections, $now);
        
        if (!empty($countsToLoad)) {
            $project->loadCount($countsToLoad);
        }

        // Compute additional aggregates that cannot be expressed via loadCount,
        // e.g. COUNT(DISTINCT user_id) for recent participants
        if ($this->shouldInclude('collaboration', $sections) || $this->shouldInclude('health', $sections)) {
            $activityDays = $this->getConfigValue(
                'time_periods.collaboration_activity_days',
                (int) config('insights.time_periods.collaboration_activity_days', 30)
            );

            $recentParticipants = $project->activities()
                ->where('created_at', '>=', (clone $now)->subDays($activityDays))
                ->distinct('user_id')
                ->count('user_id'); // count distinct user_id

            // Expose as an attribute to keep consumer code unchanged
            $project->setAttribute('recent_participants_count', $recentParticipants);
        }
    }

    /**
     * Build the map of counts to load based on requested sections
     *
    * @param array<string> $sections
    * @return array<int|string, mixed>
     */
    private function buildCountsMap(array $sections, CarbonInterface $now): array
    {
        /** @var array<string, array<string>> $sectionMappings */
        $sectionMappings = (array) config('insights.section_count_mappings', []);

        /** @var array<int|string,string> $requiredCountTypes */
        $requiredCountTypes = collect($sections)
            ->when(in_array('all', $sections), function (\Illuminate\Support\Collection $c) use ($sectionMappings): \Illuminate\Support\Collection {
                return $c->merge(array_keys($sectionMappings));
            })
            ->reject(function (string $s): bool { return $s === 'all'; })
            ->flatMap(function (string $section) use ($sectionMappings): array {
                return $sectionMappings[$section] ?? [];
            })
            ->unique()
            ->all();

        /** @var array<int|string,string> $requiredCountTypes */
        $map = collect($requiredCountTypes)
            ->mapWithKeys(function (string $type) use ($now): array {
                return $this->getCountQueriesByType($type, $now);
            })
            ->all();

        // Dev-time guard: detect accidental duplicate keys
        if (config('app.debug')) {
            $keys = array_keys($map);
            if (count($keys) !== count(array_unique($keys))) {
                throw new \LogicException('Duplicate count keys detected in ProjectInsightsRepository::buildCountsMap');
            }
        }

        return $map;
    }

    /**
     * Get count queries by type using match expression
     *
    * @param string $type
    * @return array<int|string, mixed>
     */
    private function getCountQueriesByType(string $type, CarbonInterface $now): array
    {
        // Precompute config values once per type for clarity and to avoid repeated lookups
        $conversationDays = $this->getConfigValue('time_periods.conversation_lookback_days', (int) config('insights.time_periods.conversation_lookback_days', 14));
        $meetingDays = $this->getConfigValue('time_periods.meeting_lookback_days', (int) config('insights.time_periods.meeting_lookback_days', 14));
        $collabActivityDays = $this->getConfigValue('time_periods.collaboration_activity_days', (int) config('insights.time_periods.collaboration_activity_days', 30));
        $recentActivityDays = $this->getConfigValue('time_periods.recent_activity_days', (int) config('insights.time_periods.recent_activity_days', 30));
        $riskHours = $this->getConfigValue('time_periods.risk_assessment_hours', (int) config('insights.time_periods.risk_assessment_hours', 72));
        $inactivityDays = $this->getConfigValue('time_periods.task_inactivity_days', (int) config('insights.time_periods.task_inactivity_days', 5));

        return match($type) {
            'tasks' => [
                'tasks' => fn($q) => $q->withTrashed(),
                // Active = not soft-deleted
                'tasks as active_tasks_count' => fn($q) => $q->whereNull('deleted_at'),
                'tasks as completed_tasks_count' => fn($q) => $q->completed(),
                'tasks as overdue_tasks_count' => fn($q) => $q->overdue(),
                'tasks as abandoned_tasks_count' => fn($q) => $q->onlyTrashed(),
            ],
            'communication' => [
                'conversations as recent_conversations_count' => fn($q) => $q
                    ->where('created_at', '>=', (clone $now)->subDays($conversationDays)),
            ],
            'collaboration' => [
                // Make associative to avoid numeric key in merged map
                'activeMembers as active_members_count' => fn($q) => $q,
                'meetings as recent_meetings_count' => fn($q) => $q->where(
                    'start_time',
                    '>=',
                    (clone $now)->subDays($meetingDays)
                ),

            ],
            'activity' => [
                'activities as recent_activities_count' => fn($q) => $q
                    ->where('created_at', '>=', (clone $now)->subDays($recentActivityDays)),
            ],
            'risk' => [
                'tasks as tasks_due_soon_count' => fn($q) => $q->dueSoon($riskHours),
                'tasks as tasks_at_risk_count' => fn($q) => $q
                    ->dueSoon($riskHours)
                    ->whereDoesntHave('activities', fn($subQuery) => 
                        $subQuery->where('created_at', '>=', (clone $now)->subDays($inactivityDays))
                    ),
            ],
            default => [],
        };
    }

    /**
     * Get config value with fallback
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    private function getConfigValue(string $key, mixed $default): mixed
    {
        // Prefer insights.php; fall back to project-metrics.php to preserve BC
        $insights = config("insights.{$key}");
        if ($insights !== null) return $insights;
        return config("project-metrics.{$key}", $default);
    }

    /**
     * Check if a section should be included in the response
     *
     * @param string $section
     * @param array<string> $sections
     * @return bool
     */
    private function shouldInclude(string $section, array $sections): bool
    {
        return in_array('all', $sections) || in_array($section, $sections);
    }
}
