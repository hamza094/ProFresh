<?php

namespace App\Repository;

use App\Models\Project;
use App\Data\ProjectMetricsDto;
use App\Actions\ProjectMetrics\CalculateProjectHealthAction;
use App\Actions\ProjectMetrics\CalculateTeamEngagementAction;
use App\Actions\ProjectMetrics\GetStageProgressAction;
use App\Actions\ProjectMetrics\GetUpcomingRiskAction;
use App\Actions\ProjectMetrics\CalculateCollaborationHealthAction;
use App\Actions\ProjectMetrics\CalculateProgressScoreAction;

class ProjectInsightsRepository
{
    public function __construct(
        private CalculateProjectHealthAction $projectHealthAction,
        private CalculateTeamEngagementAction $teamEngagementAction,
        private GetStageProgressAction $stageProgressAction,
        private GetUpcomingRiskAction $upcomingRiskAction,
        private CalculateCollaborationHealthAction $collaborationHealthAction,
        private CalculateProgressScoreAction $progressScoreAction
    ) {}
    public function getProjectInsights(Project $project, array $sections = ['all']): ProjectMetricsDto
    {
        // Load all required counts in a single query
        $this->loadAllRequiredCounts($project, $sections);
        
        return new ProjectMetricsDto(
            health: $this->shouldInclude('health', $sections) ? $this->projectHealthAction->execute($project) : null,
            completionRate: $this->shouldInclude('completion', $sections) ? $this->getCompletionRate($project) : null,
            overdueCount: $this->shouldInclude('overdue', $sections) ? $this->getOverdueCount($project) : null,
            teamEngagement: $this->shouldInclude('engagement', $sections) ? $this->teamEngagementAction->execute($project) : null,
            upcomingRisk: $this->shouldInclude('risk', $sections) ? $this->upcomingRiskAction->execute($project) : null,
            stageProgress: $this->shouldInclude('stage', $sections) ? $this->stageProgressAction->execute($project) : null,
            collaborationScore: $this->shouldInclude('collaboration', $sections) ? $this->collaborationHealthAction->execute($project) : null,
            progressScore: $this->shouldInclude('progress', $sections) ? $this->progressScoreAction->execute($project) : null,
        );
    }

    /**
     * Load all required counts in a single optimized query
     */
    private function loadAllRequiredCounts(Project $project, array $sections): void
    {
        $counts = [];
        
        // Health and completion metrics
        if ($this->shouldInclude('health', $sections) || 
            $this->shouldInclude('completion', $sections) || 
            $this->shouldInclude('overdue', $sections)) {
            $counts = array_merge($counts, [
                'tasks',
                'tasks as completed_tasks_count' => fn($q) => $q->completed(),
                'tasks as overdue_tasks_count' => fn($q) => $q->overdue(),
            ]);
        }
        
        // Engagement metrics
        if ($this->shouldInclude('engagement', $sections) || $this->shouldInclude('health', $sections)) {
            $counts = array_merge($counts, [
                'tasks as recent_tasks_count' => fn($q) => $q->where('updated_at', '>=', now()->subDays(7)),
                'conversations as recent_conversations_count' => fn($q) => $q->where('updated_at', '>=', now()->subDays(7)),
            ]);
        }
        
        // Collaboration metrics
        if ($this->shouldInclude('collaboration', $sections) || 
            $this->shouldInclude('engagement', $sections) || 
            $this->shouldInclude('health', $sections)) {
            $counts = array_merge($counts, [
                'activeMembers as active_members_count',
                'meetings as recent_meetings_count' => fn($q) => $q->where('created_at', '>=', now()->subDays(14)),
            ]);
        }
        
        // Activity metrics for health calculation and progress
        if ($this->shouldInclude('health', $sections) || $this->shouldInclude('progress', $sections)) {
            $counts = array_merge($counts, [
                'activities as recent_activities_count' => fn($q) => $q->where('created_at', '>=', now()->subDays(config('project-metrics.time_periods.recent_activity_days', 7))),
            ]);
        }
        
        // Single database query for all required counts
        if (!empty($counts)) {
            // Remove duplicates while preserving keys
            $counts = array_unique($counts, SORT_REGULAR);
            $project->loadCount($counts);
        }
    }

    /**
     * Check if a section should be included in the response
     */
    private function shouldInclude(string $section, array $sections): bool
    {
        return in_array('all', $sections) || in_array($section, $sections);
    }

    /**
     * Simple data retrieval methods - no business logic
     */
    private function getCompletionRate(Project $project): float
    {
        $tasksCount = $project->tasks_count ?? 0;
        $completedCount = $project->completed_tasks_count ?? 0;
        
        return $tasksCount > 0 
            ? round(($completedCount / $tasksCount) * 100, 1) 
            : 0.0;
    }

    private function getOverdueCount(Project $project): int
    {
        return $project->overdue_tasks_count ?? 0;
    }
}
