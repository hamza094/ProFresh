<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ActiveProjectMember;
use Illuminate\Validation\Rule;

class TaskMembersRequest extends FormRequest
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
        'members' => ['required',
         'array',
          'min:1',
          $this->membersValidation(),
          new ActiveProjectMember($this->task),
        ],
        'members.*' => ['required', 'exists:users,id', 'distinct'],
        ];
    }

    protected function membersValidation()
    {
        return function ($attribute, $value, $fail) {
            $existingMembersCount = $this->task->assignee()
                ->whereIn('user_id', $value)
                ->count();

            if ($existingMembersCount > 0) {
                $fail('One or more users are already assigned to the task.');
            }
        };
    }
}
