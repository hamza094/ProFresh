<?php

namespace App\Http\Requests\Api\V1\Zoom;

use DateTime;
use Illuminate\Foundation\Http\FormRequest;

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
                    'start_time' => (new DateTime($this->input('start_time')))->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                $this->merge([
                    'start_time' => null,
                ]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string>
     */
    public function rules(): array
    {
        return [
            'meeting_id' => 'integer|required',
            'topic' => 'string|max:200|sometimes',
            'agenda' => 'string|sometimes|max:2000',
            'duration' => 'integer|sometimes',
            'start_time' => 'sometimes|after:now',
            'timezone' => 'string|timezone:all|sometimes',
            'password' => 'string|max:10|sometimes',
            'join_before_host' => 'boolean|sometimes',
        ];
    }
}
