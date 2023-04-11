<?php

namespace App\Enums;
 
class OAuthProvider
{
    public const Twitter = 'twitter';
    public const GitHub = 'github';
 
    public function driver(): string
    {
        return match ($this) {
            self::Twitter => 'twitter-oauth-2',
            self::GitHub => 'github',
        };
    }
}

?>