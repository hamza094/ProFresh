<?php

declare(strict_types=1);

namespace App\Enums;

enum TaskDueNotifies: string
{
    case ONE_DAY_BEFORE = '1 Day Before';
    case TWO_HOURS_BEFORE = '2 Hours Before';
    case FIFTEEN_MINUTES_BEFORE = '15 Minutes Before';
    case FIVE_MINUTES_BEFORE = '5 Minutes Before';
    // case TWO_MINUTES_BEFORE = '2 Minutes Before';

    /**
     * Get all the enum values as an array.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the notification period in minutes for a given notification type.
     */
    public static function getPeriodInMinutes(string $notificationType): ?int
    {
        return match ($notificationType) {
            '1 Day Before' => 1440,
            '2 Hours Before' => 120,
            '15 Minutes Before' => 15,
            '5 Minutes Before' => 5,
            '2 Minutes Before' => 2,
            default => null,
        };

    }
}
