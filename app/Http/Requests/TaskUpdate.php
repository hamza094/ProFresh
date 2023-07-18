<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
            'due_at' => 'sometimes|date',
            'status_id'=>'required|sometimes'
        ];
    }
}
