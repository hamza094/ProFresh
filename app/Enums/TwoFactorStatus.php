<?php

namespace App\Enums;

enum TwoFactorStatus: string
{
    case ENABLED = 'enabled';
    case IN_PROGRESS = 'in_progress';
    case DISABLED = 'disabled';
    case TWO_FA_REQUIRED = '2fa_required';
    case SUCCESS = 'success';
} 