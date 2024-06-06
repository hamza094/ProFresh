<?php

namespace App\Http\Requests\Zoom;
use DateTime;

use Illuminate\Foundation\Http\FormRequest;

class MeetingStoreRequest extends FormRequest
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

      protected function prepareForValidation()
    {
        try {
            $this->merge([
                'start_time' => (new DateTime($this->input('start_time')))->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            $this->merge([
                'start_time' => null
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'topic'=>'string|max:200|required',
            'agenda'=>'string|max:2000|required',
            'duration'=>'integer|required',
            'start_time' => 'after:now|required',
            'timezone'=>'string|timezone:all|required',
            'password'=>'string|max:10|required',
            'join_before_host'=>'boolean|required',
        ];
    }
}
