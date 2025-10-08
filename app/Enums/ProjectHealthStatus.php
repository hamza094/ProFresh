<?php

namespace App\Enums;

enum ProjectHealthStatus: string
{
    case HOT = 'hot';
    case WARM = 'warm';
    case COLD = 'cold';
}
