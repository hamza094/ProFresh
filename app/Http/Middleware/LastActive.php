<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Closure;

class LastActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (!Auth::check()) {
        return $next($request);
    }
    $redis = Redis::connection();
    $key = 'last_active_' . Auth::id();
    $value = (new \DateTime())->format("Y-m-d H:i:s");
    $redis->set($key, $value);
    return $next($request);
    }
}
