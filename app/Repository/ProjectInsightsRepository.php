<?php

namespace App\Repository;

use App\Enums\ScoreValue;
use App\Models\Project;
use App\Models\Task;
use App\Actions\ScoreAction;

class ProjectInsightsRepository
{
    public function getProjectKPIs(Project $project, int $userId): array
    {
        // Verify user has access to this project
        if (!$project->members()->where('user_id', $userId)->exists()) {
            return [];
        }

        $health = $this->calculateProjectHealth($project);
        $completionRate = $this->getProjectCompletionRate($project);
        $overdueCount = $project->tasks()->where('due_at', '<', now())->whereNull('completed_at')->count();
        $totalTasks = $project->tasks()->count();
        $overdueRatio = $totalTasks > 0 ? round($overdueCount / $totalTasks, 2) : 0.0;
        $teamEngagement = $this->getTeamEngagement($project);
        $upcomingRisk = $this->getUpcomingRisk($project);

        return [
            'health' => [
                'value' => $health,
                'label' => 'Project Health',
            ],
            'completion_rate' => [
                'value' => $completionRate,
                'label' => 'Completion Rate',
            ],
            'overdue_count' => [
                'value' => $overdueCount,
                'label' => 'Overdue Tasks',
            ],
            'overdue_ratio' => [
                'value' => $overdueRatio,
                'label' => 'Overdue Ratio',
            ],
            'team_engagement' => [
                'value' => $teamEngagement,
                'label' => 'Team Engagement',
            ],
            'upcoming_risk' => [
                'value' => $upcomingRisk['count'],
                'label' => 'Upcoming Risk',
                'status' => $upcomingRisk['status'],
                'detail' => $upcomingRisk['detail'],
            ],
        ];
    }

    public function getProjectInsights(Project $project, int $userId): array
    {
        // Verify user has access to this project
        if (!$project->members()->where('user_id', $userId)->exists()) {
            return [];
        }

        $insights = [];
        $health = $this->calculateProjectHealth($project);
        $overdueCount = $this->getProjectOverdueCount($project);
        $engagementScore = $this->getProjectEngagementScore($project);
        $isStagnant = $this->isProjectStagnant($project);

        // Health-based insights
        if ($health >= 90) {
            $insights[] = [
                'type' => 'success',
                'title' => 'Excellent Project Health',
                'message' => 'Project is performing exceptionally well',
                'action' => 'Maintain current momentum and document best practices',
                'priority' => 'low',
            ];
        } elseif ($health < 40) {
            $insights[] = [
                'type' => 'critical',
                'title' => 'Poor Project Health',
                'message' => 'Project health is critically low',
                'action' => 'Review project scope, reassign resources, or extend deadlines',
                'priority' => 'critical',
            ];
        }

        // Overdue task insights
        if ($overdueCount > 0) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Overdue Tasks Detected',
                'message' => $overdueCount . ' tasks are past their due date',
                'action' => 'Review and reassign overdue tasks or extend deadlines',
                'priority' => $overdueCount > 3 ? 'high' : 'medium',
            ];
        }

        // Engagement insights
        if ($engagementScore >= ScoreValue::Hot_Score) {
            $insights[] = [
                'type' => 'success',
                'title' => 'High Team Engagement',
                'message' => 'Team is highly engaged with this project',
                'action' => 'Leverage this momentum for challenging tasks',
                'priority' => 'low',
            ];
        } elseif ($engagementScore < 10) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Low Team Engagement',
                'message' => 'Team engagement is below optimal levels',
                'action' => 'Check team workload and remove blockers',
                'priority' => 'medium',
            ];
        }

        // Stagnation insight
        if ($isStagnant) {
            $insights[] = [
                'type' => 'warning',
                'title' => 'Project Stagnation',
                'message' => 'No recent activity detected in the last 7 days',
                'action' => 'Schedule team check-in and identify blockers',
                'priority' => 'high',
            ];
        }

        // No tasks insight
        if ($project->tasks()->count() === 0) {
            $insights[] = [
                'type' => 'info',
                'title' => 'No Tasks Created',
                'message' => 'Project has no tasks yet',
                'action' => 'Create initial tasks to get started',
                'priority' => 'medium',
            ];
        }

        return $insights;
    }

    private function calculateProjectHealth(Project $project): float
    {
        $completionRate = $this->getProjectCompletionRate($project);
        $overduePenalty = $this->getProjectOverduePenalty($project);
        
        return max(0, min(100, $completionRate - $overduePenalty));
    }

    private function getProjectCompletionRate(Project $project): float
    {
        $totalTasks = $project->tasks()->count();
        if ($totalTasks === 0) return 0.0; // Changed from 100 to 0 for no tasks

        $completedTasks = $project->tasks()->whereNotNull('completed_at')->count();
        return round(($completedTasks / $totalTasks) * 100, 1);
    }

    private function getProjectOverdueCount(Project $project): int
    {
        return $project->tasks()
            ->where('due_at', '<', now())
            ->whereNull('completed_at')
            ->count();
    }

    private function getProjectOverduePenalty(Project $project): float
    {
        $totalTasks = $project->tasks()->count();
        if ($totalTasks === 0) return 0.0;

        $overdueCount = $this->getProjectOverdueCount($project);
        $ratio = $overdueCount / $totalTasks;
        
        return round($ratio * 40, 1); // Up to 40 points penalty
    }

    private function getProjectEngagementScore(Project $project): float
    {
        // Use existing score if available, otherwise calculate via ScoreAction
        if ($project->score !== null) {
            return (float) $project->score;
        }

        // Fallback: calculate score using ScoreAction
        $scoreAction = new ScoreAction($project);
        return (float) $scoreAction->calculateTotal();
    }

    private function isProjectStagnant(Project $project): bool
    {
        if ($project->tasks()->count() === 0) return false;
        
        $recentActivity = $project->tasks()
            ->where('updated_at', '>', now()->subDays(7))
            ->count();
            
        return $recentActivity === 0;
    }

    private function getHealthStatus(float $health): string
    {
        if ($health >= 80) return 'excellent';
        if ($health >= 60) return 'good';
        if ($health >= 40) return 'warning';
        return 'critical';
    }

    private function getCompletionStatus(float $completion): string
    {
        if ($completion >= 90) return 'excellent';
        if ($completion >= 70) return 'good';
        if ($completion >= 40) return 'warning';
        return 'critical';
    }

    private function getOverdueStatus(int $overdueCount): string
    {
        if ($overdueCount === 0) return 'good';
        if ($overdueCount <= 2) return 'warning';
        return 'critical';
    }

    private function getEngagementStatus(float $engagement): string
    {
        if ($engagement >= ScoreValue::Hot_Score) return 'hot';
        if ($engagement >= 15) return 'warm';
        return 'cold';
    }

    private function getTeamEngagement(Project $project): float
    {
        // Example: engagement = number of task updates in last 7 days
        return $project->tasks()->where('updated_at', '>=', now()->subDays(7))->count();
    }

    private function getUpcomingRisk(Project $project): array
    {
        $soonTasks = $project->tasks()
            ->where('due_at', '>=', now())
            ->where('due_at', '<=', now()->addDays(7))
            ->whereNull('completed_at')
            ->get();

        $lowProgress = $soonTasks->filter(function ($task) {
            // Example: consider low progress if updated more than 3 days ago
            return $task->updated_at < now()->subDays(3);
        });

        $count = $lowProgress->count();
        $status = $count === 0 ? 'good' : ($count <= 2 ? 'warning' : 'critical');
        $detail = $count > 0 ? "$count upcoming tasks at risk (low progress)" : "No upcoming risk";

        return [
            'count' => $count,
            'status' => $status,
            'detail' => $detail,
        ];
    }
}
