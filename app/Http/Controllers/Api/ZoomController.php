<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\DataTransferObjects\Zoom\Meeting as MeetingDto;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Illuminate\Http\Request;
use App\Http\Integrations\Zoom\ZoomConnector;
use App\Http\Resources\Zoom\MeetingResource;
use App\Interfaces\Zoom;
use F9Web\ApiResponseHelpers;
use DateTime;
use App\Models\Project;
use App\Models\Meeting;
use Illuminate\Http\JsonResponse;

class ZoomController extends Controller
{
    use ApiResponseHelpers;

  public function createMeeting(Zoom $zoom,Project $project,Request $request,ZoomConnector $connector)
  {     
    $user=auth()->user();

    try {
     $meeting =  $zoom->createMeeting(
      new NewMeetingData(
        topic: $request->topic,
        agenda: $request->agenda,
        duration: (int) $request->duration,
        password: $request->password,
        joinBeforeHost:$request->joinBeforeHost,
        startTime:  new DateTime($request->strttm),
        timezone: 'UTC'
     ),$user
    );
   } catch(ZoomException $exception){
    return response()->json(['error'=>$exception->getMessage()]);
   }

   $meetingArray = (array) $meeting;

   $meetingArray['user_id'] = auth()->id();

   $projectMeeting=$project->meetings()->create($meetingArray);

    return $this->respondCreated([
      'message'=>'Meeting Created Successfully',
      'meeting'=>new MeetingResource($projectMeeting),
    ]);        
 }

   public function show(Project $project,Meeting $meeting)
    {
      $meeting->load(['user']);

      return new MeetingResource($meeting);
    }

}
