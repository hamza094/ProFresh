<?php

declare(strict_types=1);

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Laravel\Paddle\Events\WebhookHandled;

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
