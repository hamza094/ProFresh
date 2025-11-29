<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Validator;

/**
 * Form Request for Two-Factor Authentication Login
 *
 * Handles validation for 2FA code submission during login process.
 * Validates session data, user credentials, and 2FA code.
 */
class TwoFactorLoginRequest extends FormRequest
{
    private ?string $twoFactorToken = null;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow unauthenticated users to submit 2FA codes
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'digits:6',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $code = $this->input('code');
            $this->validateTwoFactorSession($validator, $code);
        });
    }

    /**
     * Validate 2FA session and code
     */
    private function validateTwoFactorSession(Validator $validator, ?string $code): void
    {
        // Get user from encrypted session data
        $user = $this->getUserFromSession();

        if (! $user instanceof User) {
            $this->addSessionError($validator);

            return;
        }

        // Validate 2FA code
        if (! $user->validateTwoFactorCode($code)) {
            $this->handleInvalidCode($validator);

            return;
        }

        $this->forgetTwoFactorState();

        // Attach user to request for controller use
        $this->setUserResolver(fn (): User => $user);
    }

    /**
     * Retrieve and validate user from session data
     */
    private function getUserFromSession(): ?User
    {
        $creds = $this->pullSessionCredentials();

        if (! $creds) {
            return null;
        }

        if (! $this->isValidSessionData($creds)) {
            return null;
        }

        $this->twoFactorToken = $creds['token'];
        $cacheKey = $this->cacheKey();

        if (! $cacheKey) {
            return null;
        }

        // Atomically pull (get+delete) the cache entry so token cannot be reused
        $cached = Cache::pull($cacheKey);

        if (! is_array($cached)) {
            $this->forgetTwoFactorState();

            return null;
        }

        $user = $this->resolveUserFromCache($cached);

        if (! $user) {
            $this->forgetTwoFactorState();
        }

        return $user;
    }

    /**
     * Check if session data is valid and not expired
     *
     * @param  array<string, mixed>  $creds
     */
    private function isValidSessionData(array $creds): bool
    {
        return isset($creds['token'])
            && is_string($creds['token'])
            && ! empty($creds['expires_at'])
            && ! now()->greaterThan($creds['expires_at']);
    }

    /**
     * Add session error to validator
     */
    private function addSessionError(Validator $validator): void
    {
        $validator->errors()->add('code', 'Session expired or invalid. Please login again.');

        $this->forgetTwoFactorState();
    }

    /**
     * Add invalid code error to validator
     */
    private function addCodeError(Validator $validator): void
    {
        $validator->errors()->add('code', 'Invalid code provided.');
    }

    private function handleInvalidCode(Validator $validator): void
    {
        $this->addCodeError($validator);
        $this->forgetTwoFactorState();
    }

    private function forgetTwoFactorState(): void
    {
        if ($key = $this->cacheKey()) {
            Cache::forget($key);
        }
    }

    private function cacheKey(): ?string
    {
        return $this->twoFactorToken ? $this->cachePrefix().$this->twoFactorToken : null;
    }

    private function resolveUserFromCache(array $cached): ?User
    {
        if (! empty($cached['user_id'])) {
            $user = User::find($cached['user_id']);
            if ($user) {
                return $user;
            }
        }

        if (! empty($cached['email'])) {
            return User::where('email', $cached['email'])->first();
        }

        return null;
    }

    private function decryptCredentials(string $encryptedCreds): ?array
    {
        try {
            $creds = decrypt($encryptedCreds);
        } catch (Exception) {
            return null;
        }

        return is_array($creds) ? $creds : null;
    }

    private function pullSessionCredentials(): ?array
    {
        $encrypted = session()->pull($this->sessionKey());

        if (! $encrypted) {
            return null;
        }

        return $this->decryptCredentials($encrypted);
    }

    private function sessionKey(): string
    {
        return (string) config('two-factor.login_state.session_key', '2fa_login');
    }

    private function cachePrefix(): string
    {
        return (string) config('two-factor.login_state.cache_prefix', '2fa_login:');
    }
}
