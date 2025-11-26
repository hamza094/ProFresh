<?php

declare(strict_types=1);

namespace App\Services\Api\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

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
     */
    public function handleTwoFactor(User $user, string $email): bool
    {
        if ($user->hasTwoFactorEnabled()) {
            $this->forgetPreviousTwoFactorState();

            $token = hash_hmac(
                'sha256',
                Str::random(40),
                (string) (config('app.key') ?? Str::random(32))
            );

            Cache::put(
                "2fa_login:{$token}",
                [
                    'user_id' => $user->getKey(),
                    'email' => $email,
                ],
                now()->addMinutes(5)
            );

            session(['2fa_login' => encrypt([
                'token' => $token,
                'expires_at' => now()->addMinutes(5),
            ])]);

            return true;
        }

        return false;
    }

    /**
     * Remove any stale 2FA session/cache entries before issuing a new token.
     */
    private function forgetPreviousTwoFactorState(): void
    {
        $encryptedState = session('2fa_login');

        if (! $encryptedState) {
            return;
        }

        try {
            $state = decrypt($encryptedState);
        } catch (Throwable) {
            $state = null;
        }

        if (is_array($state) && isset($state['token'])) {
            Cache::forget('2fa_login:'.$state['token']);
        }

        session()->forget('2fa_login');
    }
}
