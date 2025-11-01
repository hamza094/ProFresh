<?php

declare(strict_types=1);

namespace App\Enums;

enum InsightType: string
{
    case CRITICAL = 'critical';
    case WARNING = 'warning';
    case INFO = 'info';
    case SUCCESS = 'success';
}
