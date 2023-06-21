<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class CheckSubscription
{
    use ApiResponseHelpers;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isSubscribed()) 
        {
          return $this->respondForbidden('Access denied. Only subscribed users are allowed to perform this action');
        }

        return $next($request);
    }
}
