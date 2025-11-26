<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserLogin;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
     */
    public function handle(UserLogin $event): void
    {
        try {
            $ip = Http::get('https://ipecho.net/plain')->body();

            $response = Http::get("http://ip-api.com/json/{$ip}?fields=status,message,timezone");

            if (! $response->successful()) {
                Log::warning('Could not determine timezone for IP lookup failure', [
                    'reason' => $response->status(),
                ]);

                return;
            }

            $timezone = $response->json('timezone');

            if (! $timezone) {
                Log::warning('Could not determine timezone from API response');

                return;
            }

            $event->user->timezone = $timezone;
            $event->user->save();
        } catch (Exception $e) {
            Log::error('Failed to update user timezone', ['error' => $e->getMessage()]);
        }
    }
}
