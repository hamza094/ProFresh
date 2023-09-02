<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogin //implements ShouldQueue
{
    /**
    * The user instance.
    *
    * @var \App\Models\User
    */
   public $user;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\User  $user
    * @return void
    */
    public function __construct(User $user)
    {
         $this->user=$user;
    }

}
