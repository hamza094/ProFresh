<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class AvatarController extends ApiController
{
    use ApiResponseHelpers;
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

  public function removeAvatar(User $user): JsonResponse
  {
    $this->authorize('owner', $user);

    if (!$user->avatar) {
        return $this->respondError('User does not have an avatar');
    }
      
      $user->update(['avatar_path' => null]);

      return $this->respondWithSuccess(['message'=>'User avatar has been removed']);
  }

}
