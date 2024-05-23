<?php

namespace App\Http\Requests\Zoom;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MeetingDateTime;
use DateTime;

class MeetingUpdateRequest extends FormRequest
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
        if ($this->has('start_time')) {
            try {
                $this->merge([
                    'start_time' => new DateTime($this->input('start_time'))
                ]);
            } catch (\Exception $e) {
                $this->merge([
                    'start_time' => null
                ]);
            }
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
            'meeting_id'=>'integer|required',
            'topic'=>'string|max:200|sometimes',
            'agenda'=>'string|sometimes|max:2000',
            'duration'=>'integer|sometimes',
            'start_time' => 'sometimes|date|after:now',
            'timezone'=>'string|timezone:all|sometimes',
            'password'=>'string|max:10|sometimes',
            'join_before_host'=>'boolean|sometimes',
        ];
    }
}
