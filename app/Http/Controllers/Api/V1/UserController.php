<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\UsersResource;
use App\Http\Resources\Api\V1\UserResource;
use App\Http\Requests\Api\V1\UserRequest;
use App\Services\Api\V1\UserService;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController extends ApiController
{
    /**
     * List all users
     *
     * This endpoint returns a list of all users in the application.
     *
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        
        return response()->json([
            'users' => UsersResource::collection($users)
        ], 200);
    }

    /**
     * Show user details
     *
     * Get detailed information for a specific user.
     *
     */
    public function show(User $user): JsonResponse
    {
        $user->loadMissing('members.user', 'roles');

        return response()->json([
            'message' => 'User Data',
            'user' => new UserResource($user)
        ], 200);
    }

    /**
     * Update user
     *
     * Update the specified user's information. Only the owner can update their data.
    *
   */
    public function update(UserRequest $request, User $user, UserService $userService)
    {
        $this->authorize('owner', $user);

        $userService->updateUser($user, $request->validated());

        return response()->json([
            'message' => 'User Data Updated Sucessfully',
            'user' => new UserResource($user)
        ], 200);
    }

    /**
     * Soft delete user
     *
     * Soft delete the specified user. Only the owner can delete their account.  * This will also soft delete all projects owned by the user*.
     *
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('owner', $user);

        $user->delete(); // Soft delete

        return response()->json([
            'message' => 'User Data Deleted Successfully',
        ], 200);
    }

    /**
     * Force delete user
     *
     * Permanently delete the specified user .
     *
     */
    public function forceDestroy(User $user): JsonResponse
    {
        $getUser = User::withTrashed()->findOrFail($user);
        $getUser->forceDelete(); 
        return response()->json([
            'message' => 'User Data Permanently Deleted',
        ], 200);
    }
}
