<?php

declare(strict_types=1);

namespace App\Services\Api\V1;

use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use App\Exceptions\Integrations\Zoom\ZoomException;
use Illuminate\Http\JsonResponse;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Throwable;

class ExceptionService
{
    public function handleZoom(Throwable $exception): JsonResponse
    {
        return match (true) {
            $exception instanceof UnauthorizedException => response()->json(['error' => $exception->getMessage()], 403),

            $exception instanceof NotFoundException => response()->json(['error' => $exception->getMessage()], 404),

            $exception instanceof RateLimitReachedException => response()->json([
                'error' => 'Rate limit exceeded. Please try again in '.$exception->getLimit()->getRemainingSeconds().' seconds.',
            ], 429),

            $exception instanceof ZoomException => response()->json(['error' => $exception->getMessage()], 400),

            default => response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500),
        };
    }
}
