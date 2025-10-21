<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for Preparing Two-Factor Authentication Setup
 *
 * Validates user password and ensures 2FA is not already enabled.
 */
class PrepareTwoFactorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'password' => [
                'required',
                'current_password:sanctum',
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $this->validateTwoFactorStatus($validator);
        });
    }

    /**
     * Validate that 2FA is not already enabled
     *
     * @param  \Illuminate\Validation\Validator  $validator
     */
    private function validateTwoFactorStatus($validator): void
    {
        $user = $this->user();

        if ($user && $user->hasTwoFactorEnabled()) {
            $validator->errors()->add(
                'two_factor',
                'Two-factor authentication is already enabled.'
            );
        }
    }
}
