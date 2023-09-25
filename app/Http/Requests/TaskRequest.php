<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
             'required',
             'max:55',
            Rule::unique('tasks')->where(function ($query) use ($project) {
            return $query->where('project_id', $project->id);
        }),
        ],
        ];

    } 

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
           'title.required' => 'Task title required.',
           'title.max'=>'Your task title is too long.',
           'title.unique'=>'Task with same title already exists.'
          ];
     }
  }
