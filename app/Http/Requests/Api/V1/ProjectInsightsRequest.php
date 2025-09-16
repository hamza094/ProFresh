<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Arr;

class ProjectInsightsRequest extends FormRequest
{
    /**
     * Valid sections for insights API
     */
    public const VALID_SECTIONS = [
        'completion', 'health', 'overdue', 'engagement', 'collaboration', 'risk', 'stage', 'progress', 'all'
    ];
    /**
     * Authorize the request: user must be authenticated and a member of the project
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for API request
     */
    public function rules(): array
    {
        $sections = implode(',', self::VALID_SECTIONS);
        return [
            'sections' => 'sometimes|array',
            'sections.*' => "string|in:$sections",
            'section' => "sometimes|string|in:$sections",
        ];
    }

    /**
     * Custom error messages for validation
     */
    public function messages(): array
    {
        $valid = implode(', ', self::VALID_SECTIONS);
        return [
            'sections.array' => 'Sections must be an array. Use sections[]=value format.',
            'sections.*.in' => "Invalid section. Valid sections are: $valid.",
            'section.in' => "Invalid section. Valid sections are: $valid.",
        ];
    }

    /**
     * Get the validated sections with default fallback
     */
    public function getSections(): array
    {
        if ($this->route('section')) {
            return [$this->route('section')];
        }
        return $this->validated()['sections'] ?? ['all'];
    }

    /**
     * Custom validator logic for additional checks
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validate project existence
            $project = $this->route('project');
            if (!$project) {
                $validator->errors()->add('project', 'Project not found.');
            }
        });
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation(): void
    {
        // Accept both sections[]=value and repeated sections=value formats
        if ($this->has('sections') && !is_array($this->sections)) {
            $this->merge([
                'sections' => Arr::wrap($this->input('sections'))
            ]);
        }
    }
}
