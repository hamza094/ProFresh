<?php
namespace App\Services;

use App\Http\Resources\ProjectsResource;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Auth;

class DashboardService
{
  use ApiResponseHelpers;

  public function userProjectsFilters($request)
  {
     $user=Auth::user();

     $projects=$user->projects()->get();

     $message='';

    if($request->filled('invited'))
    {
      $projects = $user->members;
    }

    if($request->filled('abandoned'))
    {
      $projects = $user->projects()->onlyTrashed()->get();
    }

    if($projects->count() == 0){
       $message='Sorry No Projects Found';
    }

      return $this->respondWithSuccess([
      'projects'=>ProjectsResource::collection($projects),
      'projectsCount'=>$projects->count(),
      'message'=>$message
      ]);
  }
    }
?>
