<?php

namespace App\Services\Insights;

use App\Enums\InsightType;

final class TaskHealthInsightBuilder implements InsightBuilderInterface
{
    private const EXCELLENT_THRESHOLD = 90;
    private const GOOD_THRESHOLD = 70;
    private const WARNING_THRESHOLD = 40;
    private const HIGH_OVERDUE_THRESHOLD = 25;
    private const HIGH_ABANDONMENT_THRESHOLD = 15;

    public function build(mixed $input, array $context = []): array
    {
        if ($input === null || !is_numeric($input)) {
            return [
                'type' => InsightType::INFO->value,
                'title' => 'No Task Data',
                'message' => 'No task data available to generate insights.',
                'data' => ['value' => null]
            ];
        }

        $value = (float) max(0, min(100, $input));
        $summary = $context['summary'] ?? [];

        return [
            'type' => $this->determineInsightType($value, $summary),
            'title' => $this->generateTitle($value),
            'message' => $this->generateMessage($value, $summary),
            'data' => ['value' => $value]
        ];
    }

    private function determineInsightType(float $value, array $summary): string
    {
        // Prioritize critical issues even with decent scores
        $overdueRate = (float) ($summary['overdue_rate'] ?? 0.0);
        $abandonmentRate = (float) ($summary['abandonment_rate'] ?? 0.0);

        if ($abandonmentRate >= self::HIGH_ABANDONMENT_THRESHOLD || $overdueRate >= self::HIGH_OVERDUE_THRESHOLD) {
            return InsightType::CRITICAL->value;
        }

        return match (true) {
            $value >= self::EXCELLENT_THRESHOLD => InsightType::SUCCESS->value,
            $value >= self::GOOD_THRESHOLD => InsightType::INFO->value,
            $value >= self::WARNING_THRESHOLD => InsightType::WARNING->value,
            default => InsightType::CRITICAL->value,
        };
    }

    private function generateTitle(float $value): string
    {
        return match (true) {
            $value >= self::EXCELLENT_THRESHOLD => 'Excellent Task Health',
            $value >= self::GOOD_THRESHOLD => 'Good Task Health',
            $value >= self::WARNING_THRESHOLD => 'Task Health Warning',
            default => 'Critical Task Issues',
        };
    }

    private function generateMessage(float $value, array $summary): string
    {
        $completionRate = (float) ($summary['completion_rate'] ?? 0.0);
        $overdueRate = (float) ($summary['overdue_rate'] ?? 0.0);
        $abandonmentRate = (float) ($summary['abandonment_rate'] ?? 0.0);

        if ($value >= self::EXCELLENT_THRESHOLD) {
            return sprintf('Task health: %.1f%% - Excellent task management with %d%% completion rate', 
                $value, (int) $completionRate);
        }

        if ($value >= self::GOOD_THRESHOLD) {
            return sprintf('Task health: %.1f%% - Good performance with %d%% completion rate', 
                $value, (int) $completionRate);
        }

        // Identify and highlight the main issue
        $primaryIssue = $this->identifyPrimaryIssue($overdueRate, $abandonmentRate, $completionRate);
        
        return match ($primaryIssue) {
            'overdue' => sprintf('Task health: %.1f%% - %d%% of tasks are overdue, affecting productivity', 
                $value, (int) $overdueRate),
            'abandonment' => sprintf('Task health: %.1f%% - %d%% task abandonment rate indicates scope issues', 
                $value, (int) $abandonmentRate),
            'completion' => sprintf('Task health: %.1f%% - Only %d%% completion rate, review execution processes', 
                $value, (int) $completionRate),
            default => sprintf('Task health: %.1f%% - Multiple issues affecting task execution', $value),
        };
    }

    private function identifyPrimaryIssue(float $overdueRate, float $abandonmentRate, float $completionRate): string
    {
        if ($overdueRate >= self::HIGH_OVERDUE_THRESHOLD) {
            return 'overdue';
        }
        
        if ($abandonmentRate >= self::HIGH_ABANDONMENT_THRESHOLD) {
            return 'abandonment';
        }
        
        if ($completionRate < 50) {
            return 'completion';
        }
        
        return 'mixed';
    }
}
