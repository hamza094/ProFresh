<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\StageStatus;
use Closure;

class StageRequest extends FormRequest
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
           * 
           * @example 1
           */
          'stage' => ['required','int',
                 function (string $attribute, mixed $value, Closure $fail) {
                     if ((int)$value === (int)$this->project->stage_id) {
                         $fail("The selected stage must be different from the current project stage.");
                     }
                 },
        ],

          /**
           * @example null
           */
          'postponed_reason' => ['sometimes','required','string',
      ],
        ];
    }

    public function messages()
{
    return [
        'stage.required' => 'The stage field is required.',
        'stage.in' => 'The selected stage is invalid. Please choose a valid stage.',
        // Add more custom messages here
    ];
}
}
