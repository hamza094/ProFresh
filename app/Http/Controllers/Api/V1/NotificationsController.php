<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\NotificationResource;
use App\Models\User;
use Auth;

class NotificationsController extends ApiController
{
  /**
     * show all notifications.
     *
     */
  public function index(){
    
    $notifications = Auth::user()
      ->notifications()
       ->latest()
       ->take(15)
       ->get();

       return NotificationResource::collection($notifications);
  }

  /**
     * Remove notification once read.
     *
     * @param  int  $user, int $notificationId
     */
  public function destroy(User $user, $notificationId)
  {
      $notification = auth()->user()->notifications()->findOrFail($notificationId);

      $notification->markAsRead();

      return json_encode(
          $notification->data
      );
  }
}
