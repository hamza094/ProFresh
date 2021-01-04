<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreProject extends FormRequest
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
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'project name required.',
            'email.required'=>'project email required',
            'mobile.required'=>'project mobile required'

        ];
    }
}
