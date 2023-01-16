<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ActivityResource;
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
     $activities = $project->activities;

      if(request()->only(['tasks', 'mine', 'specifics','members']))
      {
        $activities = $repository->filterProjectByActivity($activities);
      }


    if($activities->isEmpty()){
       return response()->json(['message'=>'No related activities found']);
    }
      
    return ActivityResource::collection($activities)->paginate(config('app.project.filters'));
   }

  }

