<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Services\FileService;
use App\Http\Requests\UserRequest;
use App\Enums\FileType;

class AvatarController extends ApiController
{
  use ApiResponseHelpers;

  public function avatar(User $user, Request $request,FileService $service)
  {
    $this->authorize('owner', $user);

    $this->validate(request(), [
    'avatar'=>[
        'required', 'image','mimes:jpeg,png,jpg'
      ]]);

    $user_path=$service->store($user->id,'avatar',FileType::AVATAR);

    $user->update(['avatar_path'=>$user_path]);

    return $this->respondWithSuccess([
      'message'=>'Avatar Updated Successfully',
      'avatar'=>$user->avatar_path,
      'path'=>$user->path(),
    ]);
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
