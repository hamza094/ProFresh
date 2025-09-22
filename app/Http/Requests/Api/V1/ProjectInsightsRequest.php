<?php
declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class ProjectInsightsRequest extends FormRequest
{
    /**
     * Valid sections for insights API
     */
    public const VALID_SECTIONS = [
        'health', 'task-health', 'collaboration', 'risk', 'stage', 'all'
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
        $in = Rule::in(self::VALID_SECTIONS);
        return [
            'sections' => ['sometimes', 'array'],
            'sections.*' => ['string', $in],
            'section' => ['sometimes', 'string', $in],
        ];
    }

    /**
     * Get the validated sections with default fallback
     */
    public function getSections(): array
    {
        // Prefer route parameter, then single 'section' input, then 'sections' array
        if ($this->route('section')) {
            return [$this->route('section')];
        }
        $validated = $this->validated();
        if (isset($validated['section'])) {
            return [$validated['section']];
        }
        return $validated['sections'] ?? ['all'];
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
