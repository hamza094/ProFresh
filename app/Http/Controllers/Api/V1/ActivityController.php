<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ActivityResource;
use App\Repository\ProjectRepository;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Activity;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ActivityController extends Controller
{
  use ApiResponseHelpers;

  public function index(Project $project,ProjectRepository $repository)
  {
    $activities = $repository->filterActivities(
      $project->activities
    );

    if($activities->isEmpty()){
       return response()->json(
        ['message'=>'No related activities found']
        ,200);
    }
      
    return ActivityResource::collection($activities)->paginate(10);
   }
  }

