<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Middleware\Zoom;

use Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class VerifyWebhookTest extends TestCase
{
    public $payload;

    public $timestamp;

    private const WEBHOOK_TEST_PATH = '/_test/webhook';

    protected function setUp(): void
    {
        parent::setUp();

        config('services.zoom.webhook_secret', 'secret');

    Route::middleware('zoom.webhook')->any(self::WEBHOOK_TEST_PATH, fn () => 'OK');

        $this->payload = [
            'event' => 'meeting.started',
            'payload' => [
                'object' => [
                    'id' => 'meeting_id',
                ],
            ],
        ];

        $this->timestamp = time();

        $this->withoutExceptionHandling();

    }

    /** @test */
    public function it_aborts_with_an_invalid_signature()
    {
        try {
            $this->post(self::WEBHOOK_TEST_PATH, $this->payload, [
                'x-zm-request-timestamp' => $this->timestamp,
                'x-zm-signature' => 'invalid-signature',
            ]);
        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());
            $this->assertEquals('The webhook signature was invalid.', $e->getMessage());

            return;
        }

        $this->fail('Expected the webhook signature to be invalid.');
    }

    /** @test */
    public function it_passes_with_a_valid_signature()
    {
        $timestamp = time();

        $signature = $this->buildSignature($timestamp, $this->payload);

        $response = $this->postJson(self::WEBHOOK_TEST_PATH, $this->payload, [
            'x-zm-request-timestamp' => $this->timestamp,
            'x-zm-signature' => $signature,
        ]);

        $this->assertEquals('OK', $response->getContent());
    }

    /** @test */
    public function it_fails_with_an_old_timestamp()
    {

        $oldTimestamp = $this->timestamp - 600;

        $signature = $this->buildSignature($oldTimestamp, $this->payload);

        try {
            $response = $this->postJson(self::WEBHOOK_TEST_PATH, $this->payload, [
                'x-zm-request-timestamp' => $oldTimestamp,
                'x-zm-signature' => $signature,
            ]);
        } catch (HttpException $e) {
            $this->assertEquals(Response::HTTP_FORBIDDEN, $e->getStatusCode());
            $this->assertEquals('The webhook signature was invalid.', $e->getMessage());

            return;
        }

        $this->fail('The timestamp should have failed verification.');
    }

    protected function buildSignature($timestamp, $payload)
    {
        $message = 'v0:'.$timestamp.':'.json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return 'v0='.hash_hmac('sha256', $message, (string) config('services.zoom.webhook_secret'));
    }
}
