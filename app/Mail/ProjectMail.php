<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        /**
         * Create a new message instance.
         *
         * @return void
         */
        protected $project,
        protected $message
    ) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.project.mail', [
            'subject' => $this->message->subject,
            'message' => $this->message->message,
            'title' => $this->project->name,
            'url' => config('app.url').'/project/'.$this->project->slug,
        ]);
    }
}
