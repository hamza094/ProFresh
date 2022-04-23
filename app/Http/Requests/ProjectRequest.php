<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ProjectRequest extends FormRequest
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
            'name'=>'sometimes|required|max:150',
            'about'=>'sometimes|required',
            'notes'=>'sometimes|present'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Project name required.',
            'about.required' => 'Project about required.',
            'name.max' => 'Project name is too long.',
        ];
    }
}
