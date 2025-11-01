<?php

declare(strict_types=1);

namespace App\Actions;

class NotificationAction
{
    public static function send($notification, $project): void
    {
        $users = $project->activeMembers->push($project->user);

        $users
            ->reject(fn ($user): bool => self::isAuthUser($user))
            ->each(fn ($user) => $user->notify($notification));
    }

    private static function isAuthUser($user): bool
    {
        return auth()->id() === $user->id;
    }
}
