<?php

namespace App\Http\Requests\Api\V1;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, \Illuminate\Contracts\Validation\Rule>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:30'],
            'email' => ['sometimes', 'required', 'email', 'max:100'],
            'username' => ['sometimes', 'required', 'alpha_dash:ascii', 'max:30'],
            'mobile' => ['sometimes', 'nullable', 'digits_between:7,15'],
            'company' => ['sometimes', 'nullable', 'string', 'max:100'],
            'bio' => ['sometimes', 'nullable', 'string', 'max:1500'],
            'address' => ['sometimes', 'nullable', 'string', 'max:150'],
            'position' => ['sometimes', 'nullable', 'string', 'max:100'],
            'current_password' => ['sometimes', 'current_password', 'required_with:password'],
            'password' => ['sometimes', 'required_with:current_password', Password::default()],
        ];
    }

     public function messages()
    {
      return [
         'current_password.current_password' => 'The given password does not match to current password.',
          'password.mixed' => 'The password must include both uppercase and lowercase letters.',
          'password.letters' => 'The password must contain at least one letter.',
          'password.symbols' => 'The password must include at least one special character (symbol).',
          'password.numbers' => 'The password must contain at least one number.',
        ];
    }
}
