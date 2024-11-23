<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Notifications\ProjectUpdated;
use Illuminate\Support\Facades\Route;

class NotificationAction 
{
  public static function send($notification,$project): void
  {
    $users = $project->activeMembers->push($project->user);
    
     $users
       ->reject(fn($user) => self::isAuthUser($user))
       ->each(fn($user) => $user->notify($notification));      
  }

  private static function isAuthUser($user): bool
  {
     return auth()->id() === $user->id;
  }

}



