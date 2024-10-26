<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Http\JsonResponse;
use App\Models\User;


class RegisterController extends ApiController
{
	    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
    * @unauthenticated
    * Register User
    * 
    * Registers a new user and returns the user API resource.
    */

    public function register(RegisterUserRequest $request){

      $validatedData = $request->validated();

    $validatedData['password'] = bcrypt($request->password);

      try {
        $user = User::create($validatedData);
        event(new Registered($user));

        return response()->json([
            'message' => 'User Registered Successfully',
            'user' => new UsersResource($user)
        ], 201);

    } catch (\Exception $e) {
        return response()->json(['error' => 'User registration failed.'], 500);
    }

    }

}
