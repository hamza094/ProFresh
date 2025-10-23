<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class PasswordUpdate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        /**
         * Create a new message instance.
         *
         * @return void
         */
        protected string $time
    ) {}

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.update',
            with: [
                'url' => config('app.url'),
                'time' => $this->time,
            ],
        );
    }
}
