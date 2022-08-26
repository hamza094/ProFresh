<?php

namespace App\Listeners;

use App\Events\UserLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SaveUserTimezone
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserLogin  $event
     * @return void
     */
    public function handle(UserLogin $event)
    {
      $ip = file_get_contents("http://ipecho.net/plain");
      $url = 'http://ip-api.com/json/'.$ip;
      $tz = file_get_contents($url);
      $tz = json_decode($tz,true)['timezone'];
      $event->user->timezone=$tz;
      $event->user->save();
    }
}
