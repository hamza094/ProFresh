<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class InvitationUsersRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules()
    {
        return [
            /**
             * - Email must be present in database
             *
             * @example maximillia.koelpin@example.com
             */
            'email' => 'required|email|exists:users,email',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.exists' => 'The email does not belong to any registered user.',
        ];
    }
}
