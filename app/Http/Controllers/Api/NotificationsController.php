<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class NotificationsController extends ApiController
{
  /**
     * show all notifications.
     *
     */
  public function index(){
    return auth()->user()->unreadNotifications;
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
