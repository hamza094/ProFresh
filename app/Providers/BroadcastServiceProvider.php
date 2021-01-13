<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

  Broadcast::channel('App.User.{userId}', function ($user, $userId) {
      return (int) $user->id === (int) $userId;
  });
    }
}
