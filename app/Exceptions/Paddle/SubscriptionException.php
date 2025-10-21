<?php

namespace App\Exceptions\Paddle;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
