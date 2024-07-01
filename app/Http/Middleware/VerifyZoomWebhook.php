<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyZoomWebhook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $providedSignature = $request->header('x-zm-signature');

        $zoomTimestamp = $request->header('x-zm-request-timestamp');

        if (!$this->isRequestValid($providedSignature, $zoomTimestamp,$request)){
         
             abort(Response::HTTP_FORBIDDEN, 'Invalid signature.');
        }

        return $next($request);
    }

     public function isRequestValid(?string $providedSignature, ?string $timestamp, Request $request): bool
    {
        return !$this->isTimestampInvalid($timestamp) 
        &&
        $this->isSignatureValid($providedSignature, $timestamp, $request);
    }

     private function isTimestampInvalid(?string $timestamp): bool
    {
        return abs(time() - $timestamp) > 300;
    }

    private function isSignatureValid(string $providedSignature, string $timestamp, Request $request): bool
    {
        $generatedSignature = $this->generateSignature($timestamp, $request);

        return hash_equals($providedSignature, $generatedSignature);
    }

    private function generateSignature(string $timestamp, Request $request): string
    {
        $message = 'v0:' . $timestamp . ':' . json_encode($request->all(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return 'v0=' . hash_hmac('sha256', $message, config('services.zoom.webhook_secret'));
    }

}
