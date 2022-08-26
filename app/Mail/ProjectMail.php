<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $project;
    protected $message;

    public function __construct($project,$message)
    {
      $this->project=$project;
      $this->message=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->markdown('emails.project.mail', [
                   'subject'=>$this->message->subject,
                   'message'=>$this->message->message,
                   'title'=>$this->project->name,
                   'url' => config('app.url').'/project/'.$this->project->slug,
               ]);
    }
}
