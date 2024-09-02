<?php

namespace App\Http\Controllers\Api\Zoom;

use App\Http\Controllers\Controller;
use App\Interfaces\Zoom;
use App\Actions\ZoomAction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Zoom\JwtTokenRequest;

class ZoomTokenController extends Controller
{
    public function getUserToken(Zoom $zoom): JsonResponse
    {
      try{
      $token = $zoom->getZakToken(auth()->user());

      return response()->json(['zak_token'=>$token]);
  }catch(\Exception){
    return response()->json(['error' => 'Unable to generate token'], 500);
  }
    }

    public function getJwtToken(JwtTokenRequest $request,ZoomAction $action): JsonResponse
    {        
      try{

        $role = $request->role;

        $meetingId = $request->meetingId;

        $token=$action->handle($meetingId,$role);
         
        return response()->json(['jwt_token'=>$token]);

    }catch(\Exception $e){
        return response()->json(['error' => 'Unable to generate token'], 500);
    }

    }
   
}
