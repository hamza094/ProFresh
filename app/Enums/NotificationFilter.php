<?php

namespace App\Enums;

enum NotificationFilter: string
{
    case READ = 'read';
    case UNREAD = 'unread';
}
