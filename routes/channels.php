<?php

use Illuminate\Support\Facades\Broadcast;
use App\Group;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('groups.{group}', function ($user, Group $group) {
    return $group->hasUser($user->id);
});

Broadcast::channel('chat', function ($user) {
  return Auth::check();
});

Broadcast::channel('chater', function ($user) {
    return $user;
});
