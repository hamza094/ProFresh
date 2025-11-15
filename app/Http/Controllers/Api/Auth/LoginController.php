<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserLogin;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Auth\LoginUserRequest;
use App\Http\Resources\Api\V1\UsersResource;
use App\Models\User;
use App\Services\Api\V1\Auth\LoginUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    public function __construct(protected LoginUserService $loginUserService) {}

    /**
     * @unauthenticated
     * Token-based login (for mobile/3rd-party clients).
     *
     * This method authenticates the user using provided credentials
     * and returns a personal access token upon successful login.
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (session('2fa_login')) {
            session()->forget('2fa_login');
        }

        $user = $this->loginUserService->attemptLogin($request->email, $request->password);

        UserLogin::dispatchIf(! $user->timezone, $user);

        if ($this->loginUserService->handleTwoFactor($user, $request->email, $request->password)) {
            return response()->json([
                'message' => 'Two-factor authentication is enabled. Please provide the verification code.',
                'status' => '2fa_required',
            ], 200);
        }

        return response()->json([
            'message' => 'User authenticated successfully',
            'user' => new UsersResource($user),
            'status' => 'success',
            'access_token' => $user->createToken(
                'Api Token for '.$user->email,
                ['*'],
                now()->addMonth())->plainTextToken,
        ], 200);
    }

    /**
     * Logout token client.
     *
     * Revokes the currently authenticated personal access token.
     */
    public function logout(Request $request): JsonResponse
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken|null $currentToken */
        $currentToken = $request->user()->currentAccessToken();
        if ($currentToken) {
            $currentToken->delete();
        }

        return response()->json(['message' => 'User logout successfully'], 200);
    }

    /**
     * @unauthenticated
     * SPA session login (cookie-based via Sanctum stateful).
     *
     * Establishes a session for first-party SPA clients.
     */
    public function loginSpa(LoginUserRequest $request): JsonResponse
    {
        if (session('2fa_login')) {
            session()->forget('2fa_login');
        }

        $user = $this->loginUserService->attemptLogin($request->email, $request->password);

        UserLogin::dispatchIf(! $user->timezone, $user);

        if ($this->loginUserService->handleTwoFactor($user, $request->email, $request->password)) {
            return response()->json([
                'message' => 'Two-factor authentication is enabled. Please provide the verification code.',
                'status' => '2fa_required',
            ], 200);
        }

        // Log the user into the session (web guard) and regenerate session ID
        Auth::guard('web')->login($user, false);
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'User authenticated successfully',
            'user' => new UsersResource($user),
            'status' => 'success',
        ], 200);
    }

    /**
     * SPA session logout (cookie-based via Sanctum stateful).
     *
     * Destroys the current session and regenerates CSRF token.
     */
    public function logoutSpa(Request $request): JsonResponse
    {
        // Log out of the session (web guard)
        Auth::guard('web')->logout();

        // Invalidate and regenerate session + CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'User logout successfully'], 200);
    }
}
