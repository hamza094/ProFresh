<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TaskAssigneeMember implements Rule
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
        return $this->task->assignee()->where('user_id', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected user is not a current member of task.';
    }
}
