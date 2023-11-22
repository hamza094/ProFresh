<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Model\TaskStatus as Status;

class maxStatusCount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $statusCount = Status::count();

        return $statusCount < 6;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
     return 'The maximum allowed number of statuses has been reached.';
    }
}
