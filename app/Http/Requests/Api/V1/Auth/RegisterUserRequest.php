<?php

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            /**
            * @example berry
             */
            'name' => 'required|string|max:100',
             'email' => 'required|string|email|max:255|unique:users',
             /**
             * Passwords require letters, mixed case,  numbers, and symbols.
             * @example Berry@04
             */
             'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                Password::default(),
            ],
        ];
    }

       /**
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'password.mixed' => 'The password must include both uppercase and lowercase letters.',
            'password.letters' => 'The password must contain at least one letter.',
            'password.symbols' => 'The password must include at least one special character (symbol).',
            'password.numbers' => 'The password must contain at least one number.',
        ];
    }
}
