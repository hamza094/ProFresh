<?php

namespace App\Http\Requests\Api\V1\Zoom;

use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
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
            'payload.object.id' => 'required',
        ];
    }
}
