<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\ApiController;

class LoginController extends ApiController
{

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

      return response()->json([
      'user' => $user,
      'access_token' => $user->createToken('access')->plainTextToken
    ], 200);
}

   public function logout(Request $request)
   {
       $request->user()->tokens()->delete();

       return response()->json('User logout successfully', 200);

   }
}

?>