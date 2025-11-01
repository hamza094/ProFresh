<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            /**
             * @example The Dimension
             */
            'name' => 'required|string|max:150|min:4',
            /**
             * @example This project is about band of the beatels
             */
            'about' => 'required|min:15',
            /**
             * @example 1
             */
            'stage_id' => 'required|int|between:1,5',
            /**
             * @example Some notes about project
             */
            'notes' => 'sometimes|max:250',
            /**
             * Only three tasks are allowed while creating project
             */
            'tasks' => 'sometimes|array|max:3',
            /**
             * @example This is project first task
             */
            'tasks.*.title' => 'required|string|min:5|max:55',
        ];
    }
}
