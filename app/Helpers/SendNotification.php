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
     foreach($project->activeMembers() as $member){

      if(auth()->id() != $member->id)
      {
        $member->notify($this->getNotification($project));
      }

    }
  }

  protected function sendNotificationToProjectOwner($project):void
  {
    if(auth()->id() != $project->user->id)
    {
      $project->user->notify($this->getNotification($project));
    }
  }

    protected function getNotification($project)
    {
      if(Route::currentRouteName() == 'projects.update')
      {
        return new ProjectUpdated($project,auth()->user()->toArray());
      }

      if(Route::currentRouteName() == 'task.store')
      {
        return new ProjectTask($project,auth()->user()->toArray());
      }
    }
  }



