<?php

namespace App\Enums;

enum StatusLevel: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case WARNING = 'warning';
    case CRITICAL = 'critical';

    public static function fromOverdue(int $count): self
    {
        $warnMax = (int) config('dashboard.statuses.overdue.warning_max', 3);
        return match (true) {
            $count === 0 => self::GOOD,
            $count <= $warnMax => self::WARNING,
            default => self::CRITICAL,
        };
    }

    public static function fromCriticalProjects(int $count): self
    {
        $warnMax = (int) config('dashboard.statuses.critical_projects.warning_max', 2);
        return match (true) {
            $count === 0 => self::GOOD,
            $count <= $warnMax => self::WARNING,
            default => self::CRITICAL,
        };
    }

    public static function fromCompletionRate(float $rate): self
    {
        $t = config('dashboard.kpi.completion_rate_status', [
            'excellent' => 80,
            'good' => 60,
            'warning' => 40,
        ]);

        return match (true) {
            $rate >= (float) ($t['excellent'] ?? 80) => self::EXCELLENT,
            $rate >= (float) ($t['good'] ?? 60) => self::GOOD,
            $rate >= (float) ($t['warning'] ?? 40) => self::WARNING,
            default => self::CRITICAL,
        };
    }

    public static function fromProjectHealth(float $health): self
    {
        $t = config('dashboard.project.kpi.health_status', [
            'excellent' => 80,
            'good' => 60,
            'warning' => 40,
        ]);

        return match (true) {
            $health >= (float) ($t['excellent'] ?? 80) => self::EXCELLENT,
            $health >= (float) ($t['good'] ?? 60) => self::GOOD,
            $health >= (float) ($t['warning'] ?? 40) => self::WARNING,
            default => self::CRITICAL,
        };
    }

    public static function fromProjectCompletion(float $completion): self
    {
        $t = config('dashboard.project.kpi.completion_rate_status', [
            'excellent' => 90,
            'good' => 70,
            'warning' => 40,
        ]);

        return match (true) {
            $completion >= (float) ($t['excellent'] ?? 90) => self::EXCELLENT,
            $completion >= (float) ($t['good'] ?? 70) => self::GOOD,
            $completion >= (float) ($t['warning'] ?? 40) => self::WARNING,
            default => self::CRITICAL,
        };
    }

    public static function fromProjectOverdue(int $count): self
    {
        $warnMax = (int) config('dashboard.project.statuses.overdue.warning_max', 2);
        return match (true) {
            $count === 0 => self::GOOD,
            $count <= $warnMax => self::WARNING,
            default => self::CRITICAL,
        };
    }

    public static function fromUpcomingRisk(int $count): self
    {
        $warnMax = (int) config('dashboard.project.statuses.upcoming_risk.warning_max', 2);
        return match (true) {
            $count === 0 => self::GOOD,
            $count <= $warnMax => self::WARNING,
            default => self::CRITICAL,
        };
    }
}
