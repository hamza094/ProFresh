<?php
namespace App\Services;
use Illuminate\Http\Request;

use App\Models\Project;
use App\Models\Meeting;
use App\Models\User;
use Auth;
use App\Http\Resources\Zoom\MeetingResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class MeetingService
{ 
  use ApiResponseHelpers;
  
  public function getMeetingsData(Project $project, bool $isPrevious): array
    {
      $meetingsQuery = $project->meetings()->with('user');

        $meetingsQuery->when($isPrevious, fn($query) => $query->previous(), fn($query) => $query->scheduled());

        $meetings = $meetingsQuery->get();

        $message = $meetings->isEmpty()
            ? 'Sorry, no meetings found.'
            : $this->getMessage($isPrevious);

        $meetingsData = MeetingResource::collection($meetings);

        $meetingsData = $meetingsData->paginate(3);

        return compact('message', 'meetingsData');
    }

    private function getMessage(bool $isPrevious): string
    {
        return $isPrevious ? 'Previous meetings' : 'Scheduled meetings';
    }
}



?>