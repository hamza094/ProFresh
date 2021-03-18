<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Notifications\ProjectUpdated;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *Send Notification to member and owner.
     *
     * @param  int  $project
    */
  public function sendNotificationToMember($project){

  	  foreach($project->activeMembers as $member){
      if(auth()->id() != $member->id){
       $member->notify(new ProjectUpdated($project));
      }
     }

      if(auth()->id() != $project->owner->id){
      $project->owner->notify(new ProjectUpdated($project));
     }
  }

}
