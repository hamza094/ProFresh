<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1;

use App\Rules\ActiveProjectMember;
use Illuminate\Foundation\Http\FormRequest;

class TaskMembersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
             * - Prevents assigning a task to users who are already assigned.
             * - Ensures tasks can only be assigned to active members of the project.
             */
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
        return function ($value, $fail): void {
            $existingMembersCount = $this->task->assignee()
                ->whereIn('user_id', $value)
                ->count();

            if ($existingMembersCount > 0) {
                $fail('One or more users are already assigned to the task.');
            }
        };
    }
}
