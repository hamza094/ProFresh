<?php

namespace App\Policies;

use App\Models\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsersPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function owner(User $user)
    {
       return $user->is(auth()->user());
    }
}
