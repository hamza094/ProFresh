<?php

declare(strict_types=1);

namespace App\Services\TwoFactor;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Throwable;

final class TwoFactorStateManager
{
    /**
     * Create a new 2FA state: cache entry + encrypted session payload.
     *
     * @return string Generated token.
     */
    public function createState(User $user, string $email): string
    {
        $minutes = (int) config('two-factor.login_state.ttl', 5);

        $token = hash_hmac(
            'sha256',
            Str::random(40),
            (string) (config('app.key') ?? Str::random(32))
        );

        [$cachePrefix, $sessionKey] = $this->getLoginStateConfig();

        Cache::put(
            $cachePrefix.$token,
            [
                'user_id' => $user->getKey(),
                'email' => $email,
            ],
            now()->addMinutes($minutes)
        );

        session([
            $sessionKey => encrypt([
                'token' => $token,
                'expires_at' => now()->addMinutes($minutes),
            ]),
        ]);

        return $token;
    }

    /**
     * Forget any 2FA state stored in session and cache.
     */
    public function forgetStateFromSession(): void
    {
        [$cachePrefix, $sessionKey] = $this->getLoginStateConfig();

        $encryptedState = session($sessionKey);

        if (! $encryptedState) {
            return;
        }

        $state = $this->decryptState($encryptedState);

        if ($state !== null && isset($state['token'])) {
            Cache::forget($cachePrefix.$state['token']);
        }

        session()->forget($sessionKey);
    }

    /**
     * Resolve a cached 2FA state by token.
     *
     * @return array<string,mixed>|null
     */
    public function resolve(string $token): ?array
    {
        [$cachePrefix] = $this->getLoginStateConfig();

        /** @var array<string,mixed>|null $state */
        $state = Cache::get($cachePrefix.$token);

        return $state;
    }

    /**
     * Delete a cached 2FA state by token.
     */
    public function delete(string $token): void
    {
        [$cachePrefix] = $this->getLoginStateConfig();

        Cache::forget($cachePrefix.$token);
    }

    /**
     * @return array{0:string,1:string} [cachePrefix, sessionKey]
     */
    private function getLoginStateConfig(): array
    {
        $cachePrefix = (string) config('two-factor.login_state.cache_prefix', '2fa_login:');
        $sessionKey = (string) config('two-factor.login_state.session_key', '2fa_login');

        return [$cachePrefix, $sessionKey];
    }

    /**
     * @return array<string,mixed>|null
     */
    private function decryptState(string $encryptedState): ?array
    {
        try {
            $state = decrypt($encryptedState);
        } catch (Throwable) {
            return null;
        }

        return is_array($state) ? $state : null;
    }
}
