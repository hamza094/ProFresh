<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserLogin;
use App\Listeners\SaveUserTimezone;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        Registered::class => [
          SendEmailVerificationNotification::class,
      ],
      UserLogin::class => [
        SaveUserTimezone::class,
    ],
      'App\Events\DashboardActivity' => [],
     'App\Events\ActivityLogged' => [],
     'App\Events\NewMessage' => [],
     'App\Events\MeetingStatusUpdate' => [],

      /*Verified::class => [
      'App\Listeners\LogVerifiedUser',
    ],*/
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
