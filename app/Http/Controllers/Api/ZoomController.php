<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Illuminate\Http\Request;
use App\Http\Integrations\Zoom\ZoomConnector;
use App\Interfaces\Zoom;
use F9Web\ApiResponseHelpers;
use DateTime;
use Illuminate\Http\JsonResponse;

class ZoomController extends Controller
{
    use ApiResponseHelpers;

    public function createMeeting(Zoom $zoom,Request $request,ZoomConnector $connector)
 {     
    $user=auth()->user();
    
    try {
     $meeting =  $zoom->createMeeting(
      new NewMeetingData(
        topic: $request->topic,
        agenda: $request->agenda,
        duration: (int) $request->duration,
        password: $request->password,
        joinBeforeHost: $request->joinBeforeHost,
        startTime:  new DateTime($request->strttm),
        timezone: 'UTC'
     ),$user
    );
   } catch(ZoomException $exception){
    return response()->json(['error'=>$exception->getMessage()]);
   }

    return $this->respondCreated([
      'message'=>'Meeting Created Successfully',
      'meeting'=>$meeting,
    ]);        
 }

}
