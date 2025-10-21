<?php

namespace App\Http\Controllers\Api\V1\Webhooks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Zoom\WebhookRequest;
use App\Jobs\Webhooks\Zoom\DeleteMeetingWebhook;
use App\Jobs\Webhooks\Zoom\MeetingEndsWebhook;
use App\Jobs\Webhooks\Zoom\StartMeetingWebhook;
use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use Illuminate\Http\JsonResponse;

class ZoomWebhookController extends Controller
{
    public function update(WebhookRequest $request): JsonResponse
    {
        $object = $request->input('payload.object');

        /** @var array<string, mixed> $object */
        UpdateMeetingWebhook::dispatch([
            'meeting_id' => $object['id'],
            'update_data' => collect($object)->except(['id', 'uuid'])->toArray(),
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function delete(WebhookRequest $request): JsonResponse
    {
        $object = $request->input('payload.object');

        DeleteMeetingWebhook::dispatch([
            'meeting_id' => $object['id'],
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function start(WebhookRequest $request): JsonResponse
    {
        $object = $request->input('payload.object');

        StartMeetingWebhook::dispatchAfterResponse([
            'meeting_id' => $object['id'],
            'start_time' => $object['start_time'] ?? null,
        ]);

        return response()->json(['status' => 'success'], 200);
    }

    public function ended(WebhookRequest $request): JsonResponse
    {
        $object = $request->input('payload.object');

        MeetingEndsWebhook::dispatchAfterResponse([
            'meeting_id' => $object['id'],
            'start_time' => $object['start_time'] ?? null,
            'end_time' => $object['end_time'] ?? null,
        ]);

        return response()->json(['status' => 'success'], 200);
    }
}
