<?php

namespace App\Enums;

enum ProjectStage: int
{
    case Planning = 1;
    case Design = 2;
    case Development = 3;
    case Testing = 4;
    case Delivery = 5;
    case Completed = 6;
    case Postponed = 7;

    public function label(): string
    {
        return match ($this) {
            self::Planning => 'Planning',
            self::Design => 'Design',
            self::Development => 'Development',
            self::Testing => 'Testing',
            self::Delivery => 'Delivery',
            self::Completed => 'Completed',
            self::Postponed => 'Postponed',
        };
    }

    public function progress(): int
    {
        return match ($this) {
            self::Planning => 0,
            self::Design => 20,
            self::Development => 40,
            self::Testing => 70,
            self::Delivery => 90,
            self::Completed => 100,
            self::Postponed => 0,
        };
    }

    public function status(): string
    {
        return match ($this) {
            self::Completed => 'completed',
            self::Postponed => 'postponed',
            default => 'in_progress',
        };
    }
}
