<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;
use Auth;

class NotificationsController extends ApiController
{
  /**
     * show all notifications.
     *
     */
  public function index(){
    
    return Auth::user()->notifications()->whereNull('read_at')->latest()->take(5)->get();
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
