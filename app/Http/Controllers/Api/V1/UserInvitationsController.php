<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Api\V1\ProjectInvitaionResource;

class UserInvitationsController extends Controller
{

    /**
     * List all pending project invitations for the authenticated user.
     *
     * @return JsonResponse
     */
    public function myInvitations(): JsonResponse
    {
        $user = auth()->user();
        // Eager load 'user' relation if ProjectInvitaionResource expects it
        $pendingInvitations = $user->members(false)->with('user')->get();

        if ($pendingInvitations->isEmpty()) {
            return response()->json([
                'invitations' => [],
                'message' => 'No pending invitations found.'
            ]);
        }

        return response()->json([
            'invitations' => ProjectInvitaionResource::collection($pendingInvitations)
        ]);
    }
}
