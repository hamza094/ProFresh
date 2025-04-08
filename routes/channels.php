<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Project;
use App\Models\User;
use App\Models\Meeting;

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

/*Broadcast::channel('activity.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('activities.project.{id}', function ($user,$id) {
      $project=Project::where('id',$id)
             ->firstOrFail();

    if($user->can('access',$project)){
        return true;
    }

    return false;
});

Broadcast::channel('project.{slug}.conversations', function ($user,$slug) {

    $project=Project::with('user')->where('slug',$slug)
             ->firstOrFail();

    if($user->can('access',$project)){
        return true;
    }

    return false;
});

Broadcast::channel('deleteConversation.{slug}', function ($user,$slug) {
    $project=Project::with('user')->where('slug',$slug)
             ->firstOrFail();

    if($user->can('access',$project)){
        return true;
    }
});

Broadcast::channel('typing.{slug}', function ($user,$slug){
    $project=Project::where('slug',$slug)
             ->firstOrFail();

    if($user->can('access',$project)){
        return true;
    }
});

Broadcast::channel('chatroom.{slug}', function ($user,$slug){

    $project=Project::where('slug',$slug)
             ->firstOrFail();

    if($user->can('access',$project)){
        return $user;
    }
});

Broadcast::channel('meetingStatus.{id}', function ($user, $id) {
    $meeting = Meeting::find($id);
    $project = $meeting->project; 
    
    return $meeting && ($user->id === $meeting->user_id || 
                        $user->id === $project->user_id || 
                        $project->activeMembers->contains($user->id));
});