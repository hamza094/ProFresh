<?php

namespace App\Enums;
 
enum TaskDueNotifies: string {
    case ONE_DAY_BEFORE = '1 Day Before';
    case TWO_HOURS_BEFORE = '2 Hours Before';
    case FIFTEEN_MINUTES_BEFORE = '15 Minutes Before';
    case FIVE_MINUTES_BEFORE = '5 Minutes Before';
    case AT_THE_TIME = 'At The Time';

     public static function asArray(): array
    {
        return [
            self::ONE_DAY_BEFORE,
            self::TWO_HOURS_BEFORE,
            self::FIFTEEN_MINUTES_BEFORE,
            self::FIVE_MINUTES_BEFORE,
            self::AT_THE_TIME,
        ];
    }
}

?>