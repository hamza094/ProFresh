<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserLogin;
use Exception;
use Illuminate\Support\Facades\Http;
use Log;

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
     * @return void
     */
    public function handle(UserLogin $event)
    {
        try {
            $ip = Http::get('https://ipecho.net/plain')->body();
            $getTz = Http::get("https://ipapi.co/{$ip}/json/")->json();
            $tz = $getTz['timezone'] ?? $getTz['time_zone'] ?? null;
            if ($tz) {
                $event->user->timezone = $tz;
                $event->user->save();
            } else {
                Log::warning("Could not determine timezone for IP {$ip}", ['response' => $getTz]);
            }

        } catch (Exception $e) {
            Log::error('Failed to update user timezone: '.$e->getMessage());
        }
    }
}
