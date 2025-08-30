<?php

namespace App\Enums;

enum InsightType: string
{
    case CRITICAL = 'critical';
    case WARNING = 'warning';
    case INFO = 'info';
    case SUCCESS = 'success';
}
