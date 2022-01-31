<?php
namespace App\Services;

use App\Http\Resources\ProjectsResource;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class DashboardService
{
  use ApiResponseHelpers;

  public function userProjectsFilters($request)
  {
    $projects = ProjectsResource::collection(auth()->user()->projects()->get());

    if($request->filled('invited'))
    {
      $projects = ProjectsResource::collection(auth()->user()->members);
    }

    if($request->filled('trashed'))
    {
      $projects = ProjectsResource::collection(auth()->user()->projects()->onlyTrashed()->get());
    }

     return $this->respondWithSuccess(['projects'=>$projects]);
  }
    }
?>
