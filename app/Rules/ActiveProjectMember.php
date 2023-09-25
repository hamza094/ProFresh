<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ActiveProjectMember implements Rule
{
    protected $task;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        $this->task = $task;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       $activeProjectMemberIds = $this->task->project->activeMembers()->pluck('users.id')->toArray();
    $invalidMembers = array_diff($value, $activeProjectMemberIds);

    return empty($invalidMembers);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One or more users are not active project members.';
    }
}
