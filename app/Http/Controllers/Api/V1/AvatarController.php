<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Services\Api\V1\FileService;
use App\Http\Requests\Api\V1\UserRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Storage;
use Aws\S3\Exception\S3Exception;
use App\Enums\FileType;

class AvatarController extends ApiController
{
    /**
     * Uploads and updates the user's avatar.
     *
     * @param User $user
     * @param Request $request
     * @param FileService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(User $user, Request $request, FileService $service): JsonResponse
    {
        $this->authorize('owner', $user);

        $request->validate([
            'avatar' => [
                'required', 'image', 'max:700', 'mimes:jpeg,png,jpg'
            ]
        ]);

      $user_path = $service->store($user->uuid,'avatar',FileType::AVATAR);

        $user->update(['avatar_path' => $user_path]);

        return response()->json([
            'message' => 'Avatar Updated Successfully',
            'avatar' => $user->avatar_path,
            'path' => $user->path(),
        ], 200);
    }

    /**
     * Removes the user's avatar and returns a JSON response.
     *
     * @param User $user
     * @param FileService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAvatar(User $user, FileService $service): JsonResponse
    {
        $this->authorize('owner', $user);

        if (!$user->avatar) {
            return response()->json([
                'message' => 'User does not have an avatar'
            ], 404);
        }

        $service->deleteFile($user);

        return response()->json([
            'message' => 'User avatar has been removed',
            'path' => $user->path(),
        ], 200);
       
    }

}
