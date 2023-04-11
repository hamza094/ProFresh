<?php

namespace App\Http\Controllers\Api\Auth;

//use App\Enums\OAuthProvider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\UserLogin;
use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResource;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\ApiController;


class OAuthController extends ApiController
{
    public function data()
    {
        /*$url = Socialite::driver($provider->driver())->stateless()->redirect()->getTargetUrl();*/
        dd('data')
    
       return response()->json(['redirect_url' => 'hello']);
    }

    
}
