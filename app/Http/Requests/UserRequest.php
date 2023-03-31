<?php

namespace App\Http\Requests;
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
     * @return array
     */
    public function rules()
    {
      return [
       'name' => 'required',
       'email' => 'required',
       'username'=> 'required|alpha_dash:ascii',
       'mobile' => 'nullable',
       'company' => 'nullable',
       'bio' => 'nullable|max:1500',
       'address' => 'nullable|max:150',
       'position' => 'nullable',
       'current_password'=>['nullable','sometimes','current_password','required_with:password'],
       'password'=>['nullable','sometimes','required_with:current_password',Password::min(8)->mixedCase()->numbers()]
        ];
    }

     public function messages()
    {
      return [
         'current_password.current_password' => 'The given password does not match to current password.',
        ];
    }
}
