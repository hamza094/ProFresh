<?php

namespace App\Listeners;

use App\Events\UserLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
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
      try{
      $ip = Http::get("http://ipecho.net/plain")->body();
      $getTz = Http::get("http://ip-api.com/json/$ip")->json();
      $tz=$getTz['timezone'];
      $event->user->timezone=$tz;
      $event->user->save();

     } catch(\Exception $e){
        \Log::error('Failed to update user timezone: ' . $e->getMessage());
     }
    }
}
