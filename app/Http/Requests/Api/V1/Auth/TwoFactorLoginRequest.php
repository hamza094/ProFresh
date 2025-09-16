<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
     * 
     * @return bool
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
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
             $code = $this->input('code'); 
            $this->validateTwoFactorSession($validator,$code);
        });
    }

    /**
     * Validate 2FA session and code
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    private function validateTwoFactorSession($validator,$code): void
    {
        // Get user from encrypted session data
        $user = $this->getUserFromSession();
        
        if (!$user) {
            $this->addSessionError($validator);
                return;
            }

        // Validate 2FA code
        if (!$user->validateTwoFactorCode($code)) {
            $this->addCodeError($validator);
                return;
            }

        // Attach user to request for controller use
        $this->setUserResolver(fn() => $user);
    }

    /**
     * Retrieve and validate user from session data
     * 
     * @return User|null
     */
    private function getUserFromSession(): ?User
    {
        $encryptedCreds = session('2fa_login');
        
        if (!$encryptedCreds) {
            return null;
        }

        try {
            $creds = decrypt($encryptedCreds);
        } catch (\Exception $e) {
            return null;
        }

        if (!$this->isValidSessionData($creds)) {
            return null;
        }

        // Look up the user from database
        $user = User::where('email', $creds['email'])->first();
        
        return $this->isValidUser($user, $creds['password']) ? $user : null;
    }

    /**
     * Check if session data is valid and not expired
     *
     * @param array<string, mixed> $creds
     * @return bool
     */
    private function isValidSessionData(array $creds): bool
    {
        return !empty($creds['email']) 
            && !empty($creds['password']) 
            && !empty($creds['expires_at']) 
            && !now()->greaterThan($creds['expires_at']);
    }

    /**
     * Validate user exists and password matches
     * 
     * @param User|null $user
     * @param string $password
     * @return bool
     */
    private function isValidUser(?User $user, string $password): bool
    {
        return $user && Hash::check($password, $user->password);
    }

    /**
     * Add session error to validator
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    private function addSessionError($validator): void
    {
        $validator->errors()->add('code', 'Session expired or invalid. Please login again.');
    }

    /**
     * Add invalid code error to validator
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    private function addCodeError($validator): void
    {
        $validator->errors()->add('code', 'Invalid code provided.');
    }
}
