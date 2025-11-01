<?php

declare(strict_types=1);

namespace App\Enums;

enum MeetingState: string
{
    case START = 'started';
    case ENDS = 'ended';
}
