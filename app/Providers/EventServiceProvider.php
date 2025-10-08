<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserLogin;
use App\Listeners\SaveUserTimezone;
use Illuminate\Support\Facades\Event;
use Laravel\Paddle\Events\WebhookReceived;
use App\Listeners\PaddleEventListener;
use Laravel\Paddle\Events\WebhookHandled;
use App\Listeners\PaddleErrorListener;
use App\Events\PasswordUpdateEvent;
use App\Listeners\SendPasswordUpdateEmail;
use App\Models\Project;
use App\Models\Task;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
       WebhookReceived::class => [
            PaddleEventListener::class,
        ],
         WebhookHandled::class => [
        PaddleErrorListener::class,
    ],
        Registered::class => [
          SendEmailVerificationNotification::class,
      ],
      UserLogin::class => [
        SaveUserTimezone::class,
    ],
      PasswordUpdateEvent::class => [
        SendPasswordUpdateEmail::class,
    ],
      'App\Events\DashboardActivity' => [],
     'App\Events\ActivityLogged' => [],
     'App\Events\NewMessage' => [],
     'App\Events\MeetingStatusUpdate' => [],
     'App\Events\ProjectHealthUpdated' => [],

      /*Verified::class => [
      'App\Listeners\LogVerifiedUser',
    ],*/
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }
}
