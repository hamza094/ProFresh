<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;


class VerificationController extends ApiController
{

  /**
    * Create a new controller instance.
    */
   public function __construct()
   {
       $this->middleware('throttle:6,1')->only('resend');
   }

   /**
 * Mark the user's email address as verified.
 */
public function verify(Request $request, User $id)
{
    if (! URL::hasValidSignature($request)) {
        return response()->json([
            'status' => trans('verification.invalid'),
        ], 400);
    }

    if ($id->hasVerifiedEmail()) {
        return response()->json([
            'status' => trans('verification.already_verified'),
        ], 400);
    }

    $id->markEmailAsVerified();

    event(new Verified($id));

    return response()->json([
        'status' => trans('verification.verified'),
    ]);
}

/**
 * Resend the email verification notification.
 */
public function resend(Request $request)
{
    $user = auth()->user();

    if (is_null($user)) {
        throw ValidationException::withMessages([
            'email' => [trans('verification.user')],
        ]);
    }

    if ($user->hasVerifiedEmail()) {
        throw ValidationException::withMessages([
            'email' => [trans('verification.already_verified')],
        ]);
    }

    $user->sendEmailVerificationNotification();

    return response()->json(['status' => trans('verification.sent')]);
}

}
