<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin;

use App\Models\Stage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StageRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('stages'),
                function ($attribute, $value, $fail): void {
                    if (Stage::count() >= 5) {
                        $fail('Cannot add more than 5 stages.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'The stage name must be unique.',
            'name.max' => 'The stage name must not exceed 255 characters.',
            'name.required' => 'The stage name is required.',
        ];
    }
}
