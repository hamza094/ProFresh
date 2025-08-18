<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UserActivitiesRequest extends FormRequest
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
            'start_date' => 'required|date_format:Y-m-d',
            'end_date'   => 'required|date_format:Y-m-d|after_or_equal:start_date',
        ];
    }

    /**
     * Get the validated and transformed date range.
     *
     * @return array
     */
    public function getDateRange(): array
    {
        $validated = $this->validated();
        return [
            'start_date' => Carbon::parse($validated['start_date'])->startOfDay(),
            'end_date'   => Carbon::parse($validated['end_date'])->endOfDay(),
        ];
    }
}
