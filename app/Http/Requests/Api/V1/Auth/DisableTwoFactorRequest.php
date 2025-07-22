<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for Disabling Two-Factor Authentication
 * 
 * Validates that 2FA is enabled before allowing disable operation.
 */
class DisableTwoFactorRequest extends FormRequest
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
        return [];
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
            $this->validateTwoFactorExists($validator);
        });
    }

    /**
     * Validate that 2FA is enabled before disabling
     * 
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    private function validateTwoFactorExists($validator): void
    {
        $user = $this->user();
        
        if (!$user->twoFactorAuth()->first()) {
            $validator->errors()->add(
                'two_factor', 
                'No Two-Factor Authentication data found to disable.'
            );
        }
    }
}
