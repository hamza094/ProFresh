<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\User;

class ResetPasswordController extends ApiController
{
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | and uses a simple trait to include this behavior. You're free to
  | This controller is responsible for handling password reset requests
  | explore this trait and override any methods you wish to tweak.
  |
  */

  /**
   * @unauthenticated
   *  Send Reset Link */
  public function sendResetLink(Request $request) {
    $request->validate(['email' => 'required|email']);

     $status = Password::sendResetLink(
         $request->only('email')
     );
     return $status === Password::RESET_LINK_SENT
                 ? back()->with(['status' => __($status)])
                 : back()->withErrors(['email' => __($status)]);
	}

   /** 
    * @unauthenticated
    * Reset User's Password */ 
   public function resetPassword(Request $request)
   {
        $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
      ]);

        $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
             'password' => Hash::make($password)
           ])->setRememberToken(Str::random(60));

      $user->save();

      event(new PasswordReset($user));
  }
);
   return $status === Password::PASSWORD_RESET
          ? back()->with('status', __($status))
          : back()->withErrors(['email' => [__($status)]]);
   }
}
