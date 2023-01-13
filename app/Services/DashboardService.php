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

  public function getUserProjects()
  {
     $projects=$this->getFilteredProjects(Auth::user())
                    ->load('stage');

     return $this->respondWithSuccess([
      'projects'=>ProjectsResource::collection($projects),
      'projectsCount'=>$projects->count(),
       'message' => $projects->isEmpty() ? 'Sorry No Projects Found' : '',
      ]);
  }

     private function getFilteredProjects($user)
     {
       if(request()->filled('member'))
       {
          return $user->affiliateProjects;
       }

       if(request()->filled('abandoned'))
       {
          return $user->projects()->onlyTrashed()->get();
       }

        return $user->projects()->get();
     }

    }
?>
