<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\OAuthProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\OAuthAction;
use Illuminate\Http\JsonResponse;
use App\Events\UserLogin;
use App\Http\Resources\UsersResource;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\ApiController;

class OAuthController extends ApiController
{
    public function redirect(OAuthProvider $provider): JsonResponse
    {
      if (auth()->check()) {
        return response()->json(['error' => 'User is already authenticated.'], 400);
    }

        $url = Socialite::driver($provider->driver())
               ->stateless()->redirect()->getTargetUrl();
    
       return response()->json(['redirect_url' => $url]);
    }


    public function callback(OAuthProvider $provider, OAuthAction $action): JsonResponse
    {
      try {

        $oAuthUser = Socialite::driver($provider->driver())->stateless()->user();

        $user = $action->createUpdateUser($oAuthUser,$provider); 

    //event(new UserLogin($user));

    return response()->json([
        'user' => new UsersResource($user),
        'message'=>'User login via Socialite',
        'access_token' => $user->createToken('access')->plainTextToken,
    ], 200);
   } catch (\Exception $e) {
     return response()->json(['message' => 'Error processing user data.', 'error' => $e->getMessage()], 500);
   }

}

}