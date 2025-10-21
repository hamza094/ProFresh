<?php

namespace App\Services\Api\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserService
{
    /**
     * Attempt to authenticate the user.
     *
     * @param  string  $email
     * @param  string  $password
     * @return User
     *
     * @throws ValidationException
     */
    public function attemptLogin($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user;
    }

    /**
     * Handle 2FA session setup if enabled.
     *
     * @param  User  $user
     * @param  string  $email
     * @param  string  $password
     * @return bool
     */
    public function handleTwoFactor($user, $email, $password)
    {
        if ($user->hasTwoFactorEnabled()) {
            session(['2fa_login' => encrypt([
                'email' => $email,
                'password' => $password,
                'expires_at' => now()->addMinutes(5),
            ])]);

            return true;
        }

        return false;
    }
}
