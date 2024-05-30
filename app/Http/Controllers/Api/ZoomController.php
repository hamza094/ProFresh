<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\DataTransferObjects\Zoom\NewMeetingData;
use App\DataTransferObjects\Zoom\UpdateMeetingData;
use App\DataTransferObjects\Zoom\Meeting as MeetingDto;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Integrations\Zoom\ZoomConnector;
use App\Http\Requests\Zoom\MeetingUpdateRequest;
use App\Http\Resources\Zoom\MeetingResource;
use App\Services\MeetingService;
use App\Interfaces\Zoom;
use F9Web\ApiResponseHelpers;
use DateTime;
use App\Models\Project;
use App\Models\Meeting;
use Illuminate\Http\JsonResponse;

class ZoomController extends Controller
{
    use ApiResponseHelpers;

  public function createMeeting(Zoom $zoom,Project $project,MeetingUpdateRequest $request,ZoomConnector $connector): JsonResponse
  {
    $this->authorize('manage', $project);
     
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
     ),
      $user
    );
   } catch(ZoomException $exception){
    return response()->json(['error'=>$exception->getMessage()], 400);
   }

   $meetingArray = array_merge((array) $meeting, ['user_id' => $user->id]);

   $projectMeeting=$project->meetings()->create($meetingArray);

    return $this->respondCreated([
      'message'=>'Meeting Created Successfully',
      'meeting'=>new MeetingResource($projectMeeting),
    ]);        
 }

  public function index(Project $project,Request $request,MeetingService $meetingService): JsonResponse
  {
     $this->authorize('access', $project);

    $isPrevious = ($request->query('request') === 'previous') ? true : false;

    $meetingsData = $meetingService->getMeetingsData($project, $isPrevious);

    return $this->respondWithSuccess($meetingsData);
  }

   public function show(Project $project,Meeting $meeting)
    {
      $meeting->load(['user']);

      return new MeetingResource($meeting);
    }

    public function update(Zoom $zoom,Project $project,Meeting $meeting,MeetingUpdateRequest $request){

    $this->authorize('manage', $project);

    DB::beginTransaction();

    try {
        $meeting->update($request->validated());

        $zoom->updateMeeting($request->validated(), auth()->user());

         DB::commit();

        $meeting->load(['user']);

        return $this->respondWithSuccess([
            'message' => 'Meeting Updated Successfully',
            'meeting' => new MeetingResource($meeting),
        ]);

    } catch (\Exception $exception) {
        DB::rollBack();

        $statusCode = $exception instanceof ZoomException ? 400 : 500;

        return response()->json(['error' => $exception->getMessage()], $statusCode);
      }     
    }

    public function destroy(Zoom $zoom,Project $project,Meeting $meeting)
    {

      $this->authorize('manage', $project);

      $Id=$meeting->id;

      $meetingId=$meeting->meeting_id;

    DB::beginTransaction();

    try {
        $meeting->delete();

        $zoom->deleteMeeting($meetingId,auth()->user());

         DB::commit();

        return $this->respondWithSuccess([
            'message' => 'Meeting Deleted Successfully',
            'meetingId' => $meetingId,
        ]);

    } catch (\Exception $exception) {
        DB::rollBack();

        $statusCode = $exception instanceof ZoomException ? 400 : 500;

        return response()->json(['error' => $exception->getMessage()], $statusCode);
      } 

    }

}
