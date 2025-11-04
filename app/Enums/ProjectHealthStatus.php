<?php

declare(strict_types=1);

namespace App\Enums;

enum ProjectHealthStatus: string
{
    case HOT = 'hot';
    case WARM = 'warm';
    case COLD = 'cold';
}
