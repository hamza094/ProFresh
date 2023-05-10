<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\OAuthProvider;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Events\UserLogin;
use Illuminate\Support\Str;
use App\Http\Resources\UsersResource;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\ApiController;

class OAuthController extends ApiController
{
    public function redirect(OAuthProvider $provider)
    {
        $url = Socialite::driver($provider->driver())
               ->stateless()->redirect()->getTargetUrl();
    
       return response()->json(['redirect_url' => $url]);
    }


    public function callback(OAuthProvider $provider)
    {
      $oAuthUser = Socialite::driver($provider->driver())
                   ->stateless()->user();
 
      $user = User::updateOrCreate([
            'oauth_id' => $oAuthUser->getId(),
            'oauth_provider' => $provider,
        ], [
            'name' => $oAuthUser->getName(),
            'email' => $oAuthUser->getEmail(),
            'password' => Hash::make(Str::random(50)),
            'username' => $oAuthUser->nickname ?? $oAuthUser->getNickname(),
            'email_verified_at' => Carbon::now(),
            'avatar_path' => $oAuthUser->getAvatar(),
            'oauth_token' => $oAuthUser->token,
            'oauth_refresh_token' => $oAuthUser->refreshToken,
        ]);
 
        //event(new UserLogin($user));

       return response()->json([
        'user' => new UsersResource($user),
        'access_token' => $user->createToken('access')->plainTextToken], 200);
    }
}
    

