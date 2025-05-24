<?php

namespace App\Listeners;

use Laravel\Paddle\Events\WebhookReceived;
use Illuminate\Support\Facades\Log;

class PaddleEventListener
{
    /**
     * Handle the received Paddle webhook event.
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;

        // Log all received payloads
        Log::info('Paddle webhook received', $payload);
        
          if ($payload['alert_name'] === 'subscription_payment_succeeded') {
            try {
                // Your custom logic here...
                // Log or trigger something if needed
                Log::info('Handled annual payment success');
            } catch (\Throwable $e) {
                Log::error('Error handling annual payment webhook', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
    }
}
