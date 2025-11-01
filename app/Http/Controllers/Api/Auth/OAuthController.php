<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\OAuthAction;
use App\Enums\OAuthProvider;
use App\Events\UserLogin;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\UsersResource;
use App\Services\Api\V1\Auth\LoginUserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends ApiController
{
    public function __construct(protected LoginUserService $loginUserService) {}

    /**
     * @unauthenticated
     * Get OAuth redirect url
     */
    public function redirect(OAuthProvider $provider): JsonResponse
    {
        if (auth()->check()) {
            return response()->json(['error' => 'User is already authenticated.'], 400);
        }
        /** @var \Laravel\Socialite\Two\AbstractProvider $socialiteDriver */
        $socialiteDriver = Socialite::driver($provider->driver());

        $url = $socialiteDriver->stateless()->redirect()->getTargetUrl();

        return response()->json(['redirect_url' => $url]);
    }

    /**
     * @unauthenticated
     *  OAuth Authentication
     *
     * API endpoint for creating or updating user and enabling login through OAuth provider callback.
     */
    public function callback(OAuthProvider $provider, OAuthAction $action): JsonResponse
    {
        try {
            /** @var \Laravel\Socialite\Two\AbstractProvider $socialiteDriver */
            $socialiteDriver = Socialite::driver($provider->driver());

            $oAuthUser = $socialiteDriver->stateless()->user();

            $user = $action->createUpdateUser($oAuthUser, $provider);

            event(new UserLogin($user));

            if ($this->loginUserService->handleTwoFactor($user, $user->email, $user->password)) {
                return response()->json([
                    'message' => 'Two-factor authentication is enabled. Please provide the verification code.',
                    'status' => '2fa_required',
                ], 200);
            }

            return response()->json([
                'user' => new UsersResource($user),
                'message' => 'User login via Socialite',
                'access_token' => $user->createToken(
                    'Api Token for '.$user->email,
                    ['*'],
                    now()->addMonth())->plainTextToken,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error processing user data.', 'error' => $e->getMessage()], 500);
        }

    }
}
