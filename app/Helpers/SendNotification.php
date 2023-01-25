<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Notifications\ProjectUpdated;
use Illuminate\Support\Facades\Route;
use App\Notifications\ProjectTask;

class SendNotification 
{

  private $notification;

  public function send($project)
  {
  	  $this->sendNotificationToMember($project);

      $this->sendNotificationToProjectOwner($project);
  }

  protected function sendNotificationToMember($project) : void
  {
    collect($project->activeMembers)
        ->reject(function ($member) {
            return auth()->id() == $member->id;
        })
        ->each(function ($member) use ($project) {
            $member->notify($this->getNotification($project));
        });
  }

  protected function sendNotificationToProjectOwner($project):void
  {
    if(auth()->id() !== $project->user->id)
    {
      $project->user->notify($this->getNotification($project));
    }
  }

    protected function getNotification($project)
    {
      $routeName = Route::currentRouteName();
      
      if($routeName == 'projects.update')
      {
        return new ProjectUpdated($project,auth()->user()->toArray());
      }

      if($routeName == 'task.store')
      {
        return new ProjectTask($project,auth()->user()->toArray());
      }
    }
  }



