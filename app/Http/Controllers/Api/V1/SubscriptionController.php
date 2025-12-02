<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\SubscriptionRequest;
use App\Http\Resources\Api\V1\SubscriptionResource;
use App\Interfaces\Paddle;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    public function subscribe(Paddle $paddle, SubscriptionRequest $request): JsonResponse
    {
        $payLink = $paddle->subscribe(auth()->user(), (string) $request->string('plan')->trim());

        return response()->json([
            'paylink' => $payLink,
        ], 200);
    }

    public function subscriptions(): JsonResponse
    {
        return response()->json([
            'subscription' => new SubscriptionResource(auth()->user()),
        ], 200);
    }

    public function swap(Paddle $paddle, SubscriptionRequest $request): JsonResponse
    {
        $result = $paddle->swap(auth()->user(), (string) $request->string('plan')->trim());

        return response()->json([
            'message' => $result['message'],
            'subscription' => new SubscriptionResource(auth()->user()),
        ], 200);
    }

    public function cancel(Paddle $paddle, SubscriptionRequest $request): JsonResponse
    {
        $result = $paddle->cancel(auth()->user(), (string) $request->string('plan')->trim());

        return response()->json([
            'message' => $result['message'],
            'subscription' => new SubscriptionResource(auth()->user()),
        ], 200);
    }
}
