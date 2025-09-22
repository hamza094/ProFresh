<?php

namespace App\Actions\ProjectMetrics;

use App\Models\Project;

class TaskHealthMetricAction
{
    public function execute(Project $project): float
    {
        // Read raw counts from the project (may come from loadCount in repository)
        [$totalTasks, $activeTasks, $completedCount, $overdueCount, $abandonedCount] = $this->getCountsFromProject($project);

        // No tasks -> neutral health
        if ($totalTasks === 0) {
            return 0.0;
        }

        $overduePenaltyMultiplier = config('project-metrics.health.task_health.overdue_penalty_multiplier', 40);
        $abandonmentPenaltyMultiplier = config('project-metrics.health.task_health.abandonment_penalty_multiplier', 30);

        $completionRate = $this->computeCompletionRate($activeTasks, $completedCount);

        $overduePenalty = $this->computeOverduePenalty($activeTasks, $completedCount, $overdueCount, $overduePenaltyMultiplier);

        $abandonmentPenalty = $this->computeAbandonmentPenalty($totalTasks, $abandonedCount, $abandonmentPenaltyMultiplier);

        $taskHealth = $completionRate - $overduePenalty - $abandonmentPenalty;

        return max(0, min(100, round($taskHealth, 1)));
    }

    /**
     * Extract counts from the project object and normalize to ints.
     * Returns: [total, active, completed, overdue, abandoned]
     */
    private function getCountsFromProject(Project $project): array
    {
        $total = (int) ($project->tasks_count ?? 0);
        $active = (int) ($project->active_tasks_count ?? 0);
        $completed = (int) ($project->completed_tasks_count ?? 0);
        $overdue = (int) ($project->overdue_tasks_count ?? 0);
        $abandoned = (int) ($project->abandoned_tasks_count ?? 0);

        return [$total, $active, $completed, $overdue, $abandoned];
    }

    /**
     * Compute completion rate as percentage of completed tasks over active (non-abandoned) tasks.
     */
    private function computeCompletionRate(int $activeTasks, int $completedCount): float
    {
        if ($activeTasks <= 0) {
            return 0.0;
        }

        return ($completedCount / $activeTasks) * 100;
    }

    /**
     * Compute overdue rate as percentage, capped at 100%
     */
    private function computeOverdueRate(int $activeTasks, int $completedCount, int $overdueCount): float
    {
        $nonCompletedActive = max(0, $activeTasks - $completedCount);
        if ($nonCompletedActive <= 0) {
            return 0.0;
        }

        return min(100.0, ($overdueCount / $nonCompletedActive) * 100);
    }

    /**
     * Compute abandonment rate as percentage
     */
    private function computeAbandonmentRate(int $totalTasks, int $abandonedCount): float
    {
        if ($totalTasks <= 0) {
            return 0.0;
        }

        return ($abandonedCount / $totalTasks) * 100;
    }

    /**
     * Compute overdue penalty using non-completed active tasks as the denominator.
     * Caps the overdue ratio at 1.0 to avoid excessive penalties.
     */
    private function computeOverduePenalty(int $activeTasks, int $completedCount, int $overdueCount, float $multiplier): float
    {
        $overdueRate = $this->computeOverdueRate($activeTasks, $completedCount, $overdueCount);
        return ($overdueRate / 100) * $multiplier;
    }

    /**
     * Compute abandonment penalty relative to total tasks (including abandoned)
     */
    private function computeAbandonmentPenalty(int $totalTasks, int $abandonedCount, float $multiplier): float
    {
        $abandonmentRate = $this->computeAbandonmentRate($totalTasks, $abandonedCount);
        return ($abandonmentRate / 100) * $multiplier;
    }

    /**
     * Public summary helper that returns task rates and counts.
     * This keeps calculations centralized in the action and prevents duplication.
     */
    public function summary(Project $project): array
    {
        [$total, $active, $completed, $overdue, $abandoned] = $this->getCountsFromProject($project);

        return [
            'completion_rate' => round($this->computeCompletionRate($active, $completed), 1),
            'overdue_rate' => round($this->computeOverdueRate($active, $completed, $overdue), 1),
            'abandonment_rate' => round($this->computeAbandonmentRate($total, $abandoned), 1),
            'active_count' => $active,
            'completed_count' => $completed,
        ];
    }
}
