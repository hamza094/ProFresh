<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
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

    public function validator($factory)
    {
    return $factory->make(
        $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
    );
    }

    public function sanitize()
    {
        $this->merge([
            'users' => json_decode($this->input('users'), true)
        ]);
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'message'=>'required|max:200',
           'mail'=>'sometimes',
           'subject'=>Rule::requiredIf(request()->mail == true),
           'sms'=>'sometimes',
           'users'=>'present|required',
           'date'=>'required_with:time',
           'time'=>'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'users.required' => "You haven't selected any user",
        ];
    }
}
