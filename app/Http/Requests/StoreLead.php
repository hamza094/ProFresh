<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreLead extends FormRequest
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
            'owner'=>'required',
            'mobile'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'lead name required.',
            'email.required'=>'lead email required',
            'owner.required'=>'lead owner required',
            'mobile.required'=>'lead mobile required'
        ];
    }
}


