<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\OAuthProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\OAuthAction;
use Illuminate\Http\JsonResponse;
use App\Events\UserLogin;
use App\Http\Resources\Api\V1\UsersResource;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\ApiController;

class OAuthController extends ApiController
{
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

        $user = $action->createUpdateUser($oAuthUser,$provider); 

        event(new UserLogin($user));

     return response()->json([
        'user' => new UsersResource($user),
        'message'=>'User login via Socialite',
        'access_token' => $user->createToken(
        'Api Token for ' . $user->email,
        ['*'],
        now()->addMonth())->plainTextToken,
    ], 200);
   } catch (\Exception $e) {
     return response()->json(['message' => 'Error processing user data.', 'error' => $e->getMessage()], 500);
   }

}

}