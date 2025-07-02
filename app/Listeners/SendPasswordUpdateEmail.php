<?php

namespace App\Listeners;

use App\Events\PasswordUpdateEvent;
use App\Mail\PasswordUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordUpdateEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordUpdateEvent $event): void
    {
        Mail::to($event->user)->send(new PasswordUpdate($event->updatedAt));
    }
}
