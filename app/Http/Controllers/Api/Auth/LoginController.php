<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserLogin;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Auth\LoginUserRequest;
use App\Http\Resources\Api\V1\UsersResource;
use App\Models\User;
use App\Services\Api\V1\Auth\LoginUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    protected LoginUserService $loginUserService;

    public function __construct(LoginUserService $loginUserService)
    {
        $this->loginUserService = $loginUserService;
    }

    /**
     * @unauthenticated
     *
     * Login User.
     *
     * This method authenticates the user using provided credentials
     * and returns an API token upon successful login.
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

    /** Logout User
     *
     * Signs out the user and destroy's the API token.
     * */
    public function logout(Request $request): JsonResponse
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken|null $currentToken */
        $currentToken = $request->user()->currentAccessToken();
        if ($currentToken) {
            $currentToken->delete();
        }

        return response()->json(['message' => 'User logout successfully'], 200);
    }
}
