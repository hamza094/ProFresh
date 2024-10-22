<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\UsersResource;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Requests\Api\V1\UserRequest;
use App\Services\Api\V1\UserService;
use App\Http\Controllers\Api\ApiController;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends ApiController
{
  use ApiResponseHelpers;

    public function index()
    {
      return UsersResource::collection(User::all());
    }

    public function show(User $user)
    {
      $user->loadMissing('members.user','roles');

      return  $this->respondWithSuccess([
        'message'=>"User Data",
        'user'=>new UserResource($user)
      ]);
    }

  public function update(UserRequest $request,User $user, UserService $userService)
  {
    $this->authorize('owner', $user);

    $userService->updateUser($user, $request->validated());

    return $this->respondWithSuccess([
        'message'=>'User Data Updated Sucessfully',
        'user'=>new UserResource($user)
      ]);
  }

  public function destroy(User $user)
  {
    $this->authorize('owner', $user);

    $user->delete();

     return $this->respondWithSuccess([
        'message'=>'User Data Deleted Sucessfully',
      ]);
  }
}
