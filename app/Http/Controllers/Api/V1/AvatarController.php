<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Services\Api\V1\FileService;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Storage;
use Aws\S3\Exception\S3Exception;
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

  public function removeAvatar(User $user,FileService $service): JsonResponse
  {
    $this->authorize('owner', $user);

    if (!$user->avatar) {
       return $this->respondError('User does not have an avatar');
    }

    try {
     
    $service->deleteFile($user);

    return $this->respondWithSuccess(['message'=>'User avatar has been removed']);

    } catch (S3Exception $e) {
       return $this->respondError($e->getMessage());
    }
  }

}
