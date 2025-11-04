<?php

declare(strict_types=1);

namespace App\Enums;

class TaskStatus
{
    // Database status IDs - keep these in sync with your seed/data
    const PENDING = 1;

    const IN_PROGRESS = 2;

    const UNDER_REVIEW = 3;

    const COMPLETED = 4;

    const CANCELLED = 5;

    /**0
     * All known status IDs
     */
    public static function all(): array
    {
        return [
            self::PENDING,
            self::IN_PROGRESS,
            self::UNDER_REVIEW,
            self::COMPLETED,
            self::CANCELLED,
        ];
    }

    /**
     * Statuses considered active (not completed/cancelled)
     */
    public static function active(): array
    {
        return [
            self::PENDING,
            self::IN_PROGRESS,
            self::UNDER_REVIEW,
        ];
    }
}
