<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordUpdate extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected string $time;

    public function __construct(string $time)
    {
      $this->time=$time;
    }

    /**
      * Get the message content definition.
    */

    public function content(): Content
    {
      return new Content(
         markdown: 'emails.user.update',
         with: [
            'url' => config('app.url'),
            'time' => $this->time
        ],
     );
    }
}
