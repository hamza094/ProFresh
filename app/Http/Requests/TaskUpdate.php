<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class TaskUpdate extends FormRequest
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

      protected function prepareForValidation()
    {
        $dueAt = $this->input('due_at');

        if ($dueAt) {

            $parsedDueAt = Carbon::parse($dueAt);

            $this->merge([
                'due_at' => $parsedDueAt,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project=$this->project;

        return [
          'title' => [
            'sometimes',
             'required',
             'max:55',
            Rule::unique('tasks')/*->ignore($this->task)*/->where(function ($query) use ($project) {
            return $query->where('project_id', $project->id);
        }),
        ],
            'description' => 'sometimes|max:350',
            'due_at' => 'sometimes|date|required_with:notified',
            'notified'=>'sometimes|required|in:1 Day Before,2 Hours Before,15 Minutes Before,5 Minutes Before,At The Time,2 Minutes Before',
            'status_id'=>'required|sometimes'
        ];
    }
}
