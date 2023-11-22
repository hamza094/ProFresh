<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\maxStatusCount;
use App\Models\TaskStatus;

class TaskStatusRequest extends FormRequest
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
            'label' => $this->isMethod('post') ? 'required|max:25|min:3' : 'sometimes|max:25|min:3',
            'color' => $this->isMethod('post') ? 'required|hex_color' : 'sometimes|hex_color',
            'status_count_check' => [new maxStatusCount()],
        ];
    }
}
