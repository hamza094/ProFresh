<?php

namespace App\Enums;

enum InsightPriority: string
{
    case CRITICAL = 'critical';
    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';
}
