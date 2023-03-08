<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Auth;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class AvatarController extends ApiController
{
  /**
    * Store user avatar.
    *
    * @param  int  $user
    *
    * @param  \Illuminate\Http\Request  $request
  */
  public function avatar(User $user, Request $request,UserService $service)
  {
    $this->validate(request(), [
      'avatar'=>['required', 'image']]);

    $user_path=$this->storeFile($request,'avatar',$user->id);

    $user->update(['avatar_path'=>$user_path]);

    return response([], 204);
  }

  public function avatarDelete(User $user)
  {
    if($user->avatar_path!==null)
    {
      $user->update(['avatar_path'=>null]);
    }
  }

}
