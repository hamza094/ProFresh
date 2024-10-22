<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\TaskDueNotifies;
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
            'description' => 'sometimes|max:1000',
            'due_at' => 'sometimes|date|required_with:notified',
            'status_id'=>'required|sometimes',
            'notified'=>[
                'sometimes',
                'required',
                Rule::in(TaskDueNotifies::values()),
            ],
        ];
    }
}
