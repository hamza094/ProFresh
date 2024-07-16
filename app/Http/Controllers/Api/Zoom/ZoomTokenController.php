<?php

namespace App\Http\Controllers\Api\Zoom;

use App\Http\Controllers\Controller;
use App\Interfaces\Zoom;
use App\Actions\ZoomAction;
use Illuminate\Http\Request;

class ZoomTokenController extends Controller
{
    public function getUserToken(Zoom $zoom)
    {
      $token = $zoom->getZakToken(auth()->user());

      return response()->json(['zak_token'=>$token]);
    }

    public function getJwtToken(ZoomAction $action)
    {
        $token=$action->handle(82251377123,1);
         
        return response()->json(['jwt_token'=>$token]);
    }
   
}
