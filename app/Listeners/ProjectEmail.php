<?php

namespace App\Listeners;

use jdavidbakr\MailTracker\Events\EmailSentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Project;

class ProjectEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailSentEvent  $event
     * @return void
     */
    public function handle(EmailSentEvent $event)
    {
      $tracker = $event->sent_email;
  $project_id = $event->sent_email->getHeader('X-Model-ID');
  $project = Project::find($project_id);

    }
}
