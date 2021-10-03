<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class SendNotification 
{

  public function send($project,$notification)
  {
  	  $this->sendNotificationToMember($project,$notification);

      $this->sendNotificationToProjectOwner($project,$notification);
  }

  protected function sendNotificationToMember($project,$notification)
  {
     foreach($project->activeMembers as $member){

      auth()->id() != $member->id ? $member->notify($notification);
    }
  }

  protected function sendNotificationToProjectOwner($project,$notification)
  {
      auth()->id() != $project->owner->id ? $project->owner->notify($notification);
  }



}
