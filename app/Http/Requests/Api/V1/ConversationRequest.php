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
            'message' => 'required_without:file|string|min:2|max:1000',
                        
            'file' => 'required_without:message|file|max:700|mimes:jpg,png,pdf,docx',
        ];
    }

    public function messages()
   {
    return [
        'message.required_without' => 'A message is required if no file is uploaded.',
        'file.required_without' => 'A file is required if no message is provided.',
    ];
   }
}
