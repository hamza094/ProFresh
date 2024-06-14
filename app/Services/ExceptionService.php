<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Exceptions\RateLimitReachedException;
use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

class ExceptionService
{
    public function handleZoom(\Exception $exception): JsonResponse
    {
         return match (true) {
            $exception instanceof UnauthorizedException => response()->json(['error' => $exception->getMessage()], 403),
            
            $exception instanceof NotFoundException => response()->json(['error' => $exception->getMessage()], 404),

            $exception instanceof RateLimitReachedException => response()->json([
                'error' => 'Rate limit exceeded. Please try again in ' . $exception->getLimit()->getRemainingSeconds() . ' seconds.'
            ], 429),

            $exception instanceof ZoomException => response()->json(['error' => $exception->getMessage()], 400),

            default => response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500),
        };
    }
}