<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Project;
use Illuminate\Validation\ValidationException;


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

    protected function prepareForValidation(): void
    {

     /** @var Project $project */
     $project = $this->route('project');
       
      throw_if($project->tasksReachedItsLimit(),
      ValidationException::withMessages(
        ['tasks'=>'Project tasks reached their limit'])
       );
    }


    public function rules()
    {
        $project=$this->project;

      return [
          /**
             * Tasks title
             * 
             * - Project task must be unique
             * 
             * @example "this is a new project task"
             */
            'title' => [
             'required',
             'max:55',
             'min:3',
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
