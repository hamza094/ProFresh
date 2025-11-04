<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class DashboardProjectRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            /**
             * @example frontend
             */
            'search' => 'nullable|string|max:25',
            /**
             * @example latest
             */
            'sort' => 'nullable|string|in:latest,oldest',
            /**
             * @example true
             */
            'member' => 'nullable|boolean',
            /**
             * @example false
             */
            'abandoned' => 'nullable|boolean',
            /**
             * @example 1
             */
            'page' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'sort.in' => 'Sort must be either latest or oldest',
            'page.min' => 'Page must be at least 1',
        ];
    }
}
