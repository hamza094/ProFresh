<?php

namespace App\Mail;

use App\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
   public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message,$subject)
    {
        $this->message = $message;
       $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.lead.mail');
    }
}
