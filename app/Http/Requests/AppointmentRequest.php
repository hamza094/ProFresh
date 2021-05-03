<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
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
        $rules = [
        'title'=>'required',
        'strttm'=>'required',
        'zone'=>'required',
        'location'=>'required',
        'outcome'=>'required',
        ];

        if ($this->getMethod() == 'POST') {
        $rules += ['strtdt' => 'required'];
    }

      return $rules;
    }

}
