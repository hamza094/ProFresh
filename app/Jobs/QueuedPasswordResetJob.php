<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Models\User;

class QueuedPasswordResetJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

   protected User $user;
   protected string $token;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $token)
    {
       //the user property passed to the constructor through the job dispatch method
       $this->user = $user;
       $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       //This queued job sends
       //Illuminate\Auth\Notifications\ResetPassword notification
       //to the user by triggering the notification
       $this->user->notify(new ResetPassword($this->token));
    }
}
