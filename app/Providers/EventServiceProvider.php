<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
          SendEmailVerificationNotification::class,
      ],
      'jdavidbakr\MailTracker\Events\EmailSentEvent' => [
         'App\Listeners\ProjectEmail'
     ],
     'jdavidbakr\MailTracker\Events\ViewEmailEvent' => [
         'App\Listeners\EmailViewed',
     ],
     'jdavidbakr\MailTracker\Events\LinkClickedEvent' => [
         'App\Listeners\EmailLinkClicked',
     ],
     'jdavidbakr\MailTracker\Events\EmailDeliveredEvent' => [
         'App\Listeners\EmailDelivered',
     ],
     'jdavidbakr\MailTracker\Events\ComplaintMessageEvent' => [
         'App\Listeners\EmailComplaint',
     ],
     'jdavidbakr\MailTracker\Events\PermanentBouncedMessageEvent' => [
         'App\Listeners\BouncedEmail',
     ],


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
