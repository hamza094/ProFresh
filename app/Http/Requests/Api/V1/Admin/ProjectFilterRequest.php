<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'sort' => ['sometimes', 'required', 'in:asc,desc'],
            'search' => ['sometimes'],
            'filter' => ['sometimes', 'in:active,trashed'],
            'members' => ['sometimes', 'required'],
            'status' => ['sometimes', 'required', 'in:cold,hot'],
            'tasks' => ['sometimes', 'required'],
            'stage' => ['sometimes', 'required', 'int', 'min:0', 'max:6'],
            'from' => ['sometimes', 'required', 'date', 'required_with:to'],
            'to' => ['sometimes', 'required', 'date', 'required_with:from'],
        ];
    }
}
