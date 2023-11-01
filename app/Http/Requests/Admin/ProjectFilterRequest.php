<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFilterRequest extends FormRequest
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
            'sort' => ['sometimes', 'required', 'in:asc,desc'],
            'search'=>['sometimes'],
            'filter'=>['sometimes','in:active,trashed'],
            'members'=>['sometimes','required'],
            'status'=>['sometimes','required','in:cold,hot'],
            'tasks'=>['sometimes','required'],
            'stage'=>['sometimes','required','int','min:0','max:6'],
            'from'=>['sometimes','required','date','required_with:to'],
            'to'=>['sometimes','required','date','required_with:from'],
        ];
    }
}
