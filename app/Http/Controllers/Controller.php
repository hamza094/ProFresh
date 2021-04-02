<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use File;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     *Send Notification to member and owner.
     *
     * @param  int  $project
    */
  public function sendNotification($project,$notification)
  {
  	  $this->sendNotificationToMember($project,$notification);

      $this->sendNotificationToProjectOwner($project,$notification);
  }

    /**
    * Send Notification to member.
    *
    * @param  int  $project
    */
  protected function sendNotificationToMember($project,$notification)
  {
     foreach($project->activeMembers as $member){
      if(auth()->id() != $member->id){
       $member->notify($notification);
      }
     }
  }

  /**
    * Send Notification to owner.
    *
    * @param  int  $project
    */
  protected function sendNotificationToProjectOwner($project,$notification)
  {
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

    /**
     * Store file in s3 storage.
     *
     * @param  string $name, int $id
     */
  public function storeFile($request,$name,$id)
  {
    $file = $request->file($name);
    $filename = uniqid($id.'_').'.'.$file->getClientOriginalExtension();
    Storage::disk('s3')->put($filename, File::get($file), 'public');
    //Store Profile Image in s3
    $path = Storage::disk('s3')->url($filename);
    return $path;
  }

}
