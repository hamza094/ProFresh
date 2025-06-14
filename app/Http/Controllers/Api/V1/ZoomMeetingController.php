<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\DataTransferObjects\Zoom\UpdateMeetingData;
use App\DataTransferObjects\Zoom\Meeting as MeetingDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Integrations\Zoom\ZoomConnector;
use App\Http\Requests\Api\V1\Zoom\MeetingUpdateRequest;
use App\Http\Requests\Api\V1\Zoom\MeetingStoreRequest;
use App\Http\Resources\Api\V1\Zoom\MeetingResource;
use App\Services\Api\V1\MeetingService;
use App\Interfaces\Zoom;
use DateTime;
use Illuminate\Support\Facades\Cache;
use App\Models\Project;
use App\Models\Meeting;
use App\Services\Api\V1\ExceptionService;
use Illuminate\Http\JsonResponse;
use App\Exceptions\Integrations\Zoom\ZoomException;

class ZoomMeetingController extends Controller
{
    protected $exceptionService;

    public function __construct(ExceptionService $exceptionService)
    {
        $this->exceptionService = $exceptionService;
    }

    public function index(Project $project, Request $request, MeetingService $meetingService): JsonResponse
    {
        $this->authorize('access', $project);

        $isPrevious = ($request->query('request') === 'previous');

        $meetingsData = $meetingService->getMeetingsData($project, $isPrevious);

        return response()->json([
            'success' => true,
            'message' => $meetingsData['message'],
            'meetingsData' => $meetingsData['meetingsData']
        ], 200);
    }

    public function show(Project $project, Meeting $meeting): JsonResponse
    {
        $this->authorize('access', $project);
        $meeting->load(['user']);
        return response()->json(['success' => true, 'data' => new MeetingResource($meeting)], 200);
    }

    public function store(Zoom $zoom, Project $project, MeetingStoreRequest $request): JsonResponse
    {
        $this->authorize('manage', $project);

        $user = auth()->user();

        $projectMeeting = DB::transaction(function () use ($zoom, $project, $user, $request) {
            $meeting = $zoom->createMeeting($request->validated(), $user);
            $meetingArray = (array) $meeting + ['user_id' => $user->id];
            return $project->meetings()->create($meetingArray);
        });

        return response()->json([
            'message' => 'Meeting Created Successfully',
            'meeting' => new MeetingResource($projectMeeting),
        ], 201);
    }

    public function update(Zoom $zoom, Project $project, Meeting $meeting, MeetingUpdateRequest $request): JsonResponse
    {
        $this->authorize('manage', $project);

        DB::transaction(function () use ($zoom, $meeting, $request) {
            $meeting->update($request->validated());
            $zoom->updateMeeting($request->validated(), auth()->user());
        });

        $meeting->load(['user']);

        return response()->json([
            'message' => 'Meeting Updated Successfully',
            'meeting' => new MeetingResource($meeting),
        ], 200);
    }

    public function destroy(Zoom $zoom, Project $project, Meeting $meeting): JsonResponse
    {
        $this->authorize('manage', $project);

        $meetingId = $meeting->meeting_id;

        DB::transaction(function () use ($zoom, $meeting, $meetingId) {
            $meeting->delete();
            $zoom->deleteMeeting($meetingId, auth()->user());
        });

        return response()->json([
            'message' => 'Meeting Deleted Successfully',
        ], 200);
    }
}
