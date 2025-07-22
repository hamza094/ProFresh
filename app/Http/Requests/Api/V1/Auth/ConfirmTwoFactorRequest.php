<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Form Request for Confirming Two-Factor Authentication Setup
 * 
 * Validates 2FA code and ensures setup is not already confirmed.
 */
class ConfirmTwoFactorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
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
            $this->validateTwoFactorSetup($validator);
        });
    }

    /**
     * Validate 2FA setup status and code
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    private function validateTwoFactorSetup($validator): void
    {
        $user = $this->user();
        
        if ($user && $user->hasTwoFactorEnabled()) {
            $validator->errors()->add(
                'two_factor', 
                'Two-factor is already confirmed.'
            );
            return;
        }
        
        // Validate the 2FA code
        if ($user && !$user->hasTwoFactorEnabled() && !$user->confirmTwoFactorAuth($this->code)) {
            $validator->errors()->add('code', 'Invalid code provided.');
        }
    }
}
