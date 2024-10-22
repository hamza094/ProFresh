<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Events\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;

class LoginController extends ApiController
{

  /**
 * Login User.
 *
 * This method authenticates the user using provided credentials
 * and returns an API token upon successful login.
 */

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        /**
            *
             * @example Berry@04
             */
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    UserLogin::dispatchIf(!$user->timezone, $user);

    return response()->json([
      'message'=> 'User authenticated successfully',
      'user' => new UsersResource($user),
      'access_token' => $user->createToken(
        'Api Token for ' . $user->email,
        ['*'],
        now()->addMonth())->plainTextToken
    ], 
    200);
}
   

    /** Logout User 
     * 
     * Signs out the user and destroy's the API token.
     * */
   public function logout(Request $request)
   {
       $request->user()->currentAccessToken()->delete();

       return response()->json(['message'=>'User logout successfully'], 200);

   }
}

?>
