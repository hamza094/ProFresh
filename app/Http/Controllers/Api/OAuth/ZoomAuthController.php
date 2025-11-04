<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\OAuth;

use App\DataTransferObjects\Zoom\AuthorizationCallbackDetails;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Http\Controllers\Controller;
use App\Interfaces\Zoom;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ZoomAuthController extends Controller
{
    public function redirect(Request $request): JsonResponse
    {
        $redirectDetails = app(Zoom::class)
            ->getAuthRedirectDetails();

        session()->put('oauth_zoom_state', $redirectDetails->state);

        session()->put('oauth_zoom_code_verifier', $redirectDetails->codeVerifier);

        return response()->json(['redirectUrl' => $redirectDetails->authorizationUrl]);

    }

    public function callback(Request $request): JsonResponse
    {
        if ($request->input('error') === 'access_denied') {
            return response()->json(['error' => 'Zoom account connection denied'], 400);
        }

        $hasRequiredFields = $request->filled(['code', 'state'])
          && session()->has('oauth_zoom_state')
          && session()->has('oauth_zoom_code_verifier');

        if (! $hasRequiredFields) {
            return response()->json(['error' => 'Missing required fields'], 400);
        }

        $callbackDetails = new AuthorizationCallbackDetails(
            authorizationCode: $request->input('code'),
            expectedState: session()->pull('oauth_zoom_state'),
            state: $request->input('state'),
            codeVerifier: session()->pull('oauth_zoom_code_verifier'),
        );

        try {
            $accessDetails = app(Zoom::class)->authorize($callbackDetails);

            auth()->user()->updateZoomOAuthDetails(
                accessToken: $accessDetails->accessToken,
                refreshToken: $accessDetails->refreshToken,
                expiresAt: $accessDetails->expiresAt,
            );
        } catch (ZoomException) {
            return response()->json(['error' => 'Failed to connect to Zoom account'], 400);
        }

        return response()->json(['success' => 'Zoom account connected successfully']);

    }
}
