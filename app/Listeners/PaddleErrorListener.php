<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Paddle\Events\WebhookHandled;
use Illuminate\Support\Facades\Log;

class PaddleErrorListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookHandled $event): void
    {
             Log::info('Paddle webhook handled', [
            'payload' => $event->payload,
        ]);

    }
}
