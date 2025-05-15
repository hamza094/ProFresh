<?php

namespace App\Exceptions\Paddle;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionException extends Exception
{
    public function render(Request $request): JsonResponse|bool
    {
        if ($request->is('api/*')) {
            return response()->json([
                'message' => $this->getMessage(),
            ], 409);
        }
        return false;
    }
}
