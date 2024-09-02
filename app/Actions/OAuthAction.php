<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OAuthAction
{
  public function createUpdateUser($oAuthUser,$provider)
  {
    $user = User::where('email', $oAuthUser->getEmail())->first();

   return    $user = User::updateOrCreate(
            [
                'email'=>$oAuthUser->getEmail(),
            ],
            [
              'name' => $user->name ?? $oAuthUser->getName(),
              'password' => $user->password ?? Hash::make(Str::random(50)),
              'username' => $user->username ?? ($oAuthUser->nickname ?? $oAuthUser->getNickname()),
              'oauth_id' => $oAuthUser->getId(),
              'oauth_provider' => $provider,
              'email_verified_at' => $user->email_verified_at ?? Carbon::now(),
              'avatar_path' => $user->avatar_path ?? $oAuthUser->getAvatar(),
              'oauth_token' => $oAuthUser->token,
              'oauth_refresh_token' => $oAuthUser->refreshToken,
            ]
        );
  }

 

}



