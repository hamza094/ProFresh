<?php

namespace App\Enums;
 
enum OAuthProvider: string
{
    case Twitter = 'twitter';
 
    case GitHub = 'github';

    case Google = 'google';
 
    public function driver(): string
    {
        return match ($this) {
            self::Twitter => 'twitter-oauth-2',
            self::GitHub => 'github',
            self::Google => 'google',
        };
    }
}

?>