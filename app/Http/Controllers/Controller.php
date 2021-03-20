<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *Send Notification to member and owner.
     *
     * @param  int  $project
    */
  public function sendNotificationToMember($project,$notification)
  {
  	  foreach($project->activeMembers as $member){
      if(auth()->id() != $member->id){
       $member->notify($notification);
      }
     }

      if(auth()->id() != $project->owner->id){
      $project->owner->notify($notification);
     }
  }

    /**
     * Add score.
     *
     * @param  string $project, int $count
    */
  public function recordScore($project,$message,$count)
  {
    if(!$project->scores()->where('message',$message)->exists()){
          $project->addScore($message,$count);
        };
  }

}
