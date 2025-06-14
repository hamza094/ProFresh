<?php

namespace App\Http\Controllers\Api\V1\Zoom;

use App\Http\Controllers\Controller;
use App\Interfaces\Zoom;
use App\Actions\ZoomAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\V1\Zoom\JwtTokenRequest;
use Dedoc\Scramble\Attributes\ExcludeAllRoutesFromDocs;

#[ExcludeAllRoutesFromDocs]
class ZoomTokenController extends Controller
{
    public function getUserToken(Zoom $zoom): JsonResponse
    {
      $token = $zoom->getZakToken(auth()->user());

      return response()->json(['zak_token'=>$token]);
    }

    public function getJwtToken(JwtTokenRequest $request,ZoomAction $action): JsonResponse
    {        
        $role = $request->role;

        $meetingId = $request->meetingId;

        $token = $action->handle($meetingId, $role);

        return response()->json(['jwt_token' => $token]);
    }
   
}
