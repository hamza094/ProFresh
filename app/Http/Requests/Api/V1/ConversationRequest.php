<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ConversationRequest extends FormRequest
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
            'message'=>'string|sometimes|required_without:file',
            'file'=>'sometimes|required_without:message|file|size:700|mimes:jpg,png,pdf,docx|mimetypes:image/jpeg,image/png,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];
    }
}
