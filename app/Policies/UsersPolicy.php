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

    public function before(User $user, string $ability): bool|null
    {
      if ($user->isAdmin()) {
          return true;
      }
 
      return null; 
   }

    public function owner(User $user): bool
    {
       return $user->is(auth()->user());
    }

}
