<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
    {
        if (! auth()->user()->isSubscribed()) {
            return response()->json([
                'error' => 'Access denied. Only subscribed users are allowed to perform this action',
            ], 403);
        }

        return $next($request);
    }
}
