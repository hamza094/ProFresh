<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
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
      $user->loadMissing('members.user');

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
    $user->delete();

    if(request()->expectsJson())
    {
      return response(['status'=>'profile deleted']);
    }
  }
}
