<?php

namespace App\Http\Requests\Api\V1;

use App\Models\Project;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class ProjectUpdateRequest extends FormRequest
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
            /**
             * @example The Lightning rod
             */
            'name' => [
                'sometimes', 'required', 'max:150', 'string', 'min:4',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value === $this->project->name) {
                        $fail("The {$attribute} must be different from the current name.");
                    }
                },
            ],
            /**
             * @example This project aims to revolutionize the tech industry by...
             */
            'about' => [
                'sometimes', 'required', 'min:15',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value === $this->project->about) {
                        $fail("The {$attribute} must be different from the current about description.");
                    }
                },
            ],
            /**
             * @example These notes are for internal use only and outline key considerations.
             */
            'notes' => [
                'sometimes', 'present', 'max:250',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($this->has('notes') && $value === $this->project->notes) {
                        $fail("The {$attribute} must be different from the current project notes.");
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Project name required.',
            'about.required' => 'Project about required.',
            'name.max' => 'Project name is too long.',
        ];
    }
}
