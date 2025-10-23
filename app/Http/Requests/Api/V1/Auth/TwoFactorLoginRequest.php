<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

/**
 * Form Request for Two-Factor Authentication Login
 *
 * Handles validation for 2FA code submission during login process.
 * Validates session data, user credentials, and 2FA code.
 */
class TwoFactorLoginRequest extends FormRequest
{
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
        $validator->after(function (Validator $validator) {
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

        if (!$user instanceof \App\Models\User) {
            $this->addSessionError($validator);

            return;
        }

        // Validate 2FA code
        if (! $user->validateTwoFactorCode($code)) {
            $this->addCodeError($validator);

            return;
        }

        // Attach user to request for controller use
        $this->setUserResolver(fn () => $user);
    }

    /**
     * Retrieve and validate user from session data
     */
    private function getUserFromSession(): ?User
    {
        $encryptedCreds = session('2fa_login');

        if (! $encryptedCreds) {
            return null;
        }

        try {
            $creds = decrypt($encryptedCreds);
        } catch (\Exception) {
            return null;
        }

        if (! $this->isValidSessionData($creds)) {
            return null;
        }

        // Look up the user from database
        $user = User::where('email', $creds['email'])->first();

        return $this->isValidUser($user, $creds['password']) ? $user : null;
    }

    /**
     * Check if session data is valid and not expired
     *
     * @param  array<string, mixed>  $creds
     */
    private function isValidSessionData(array $creds): bool
    {
        return ! empty($creds['email'])
            && ! empty($creds['password'])
            && ! empty($creds['expires_at'])
            && ! now()->greaterThan($creds['expires_at']);
    }

    /**
     * Validate user exists and password matches
     */
    private function isValidUser(?User $user, string $password): bool
    {
        return $user && Hash::check($password, $user->password);
    }

    /**
     * Add session error to validator
     */
    private function addSessionError(Validator $validator): void
    {
        $validator->errors()->add('code', 'Session expired or invalid. Please login again.');
    }

    /**
     * Add invalid code error to validator
     */
    private function addCodeError(Validator $validator): void
    {
        $validator->errors()->add('code', 'Invalid code provided.');
    }
}
