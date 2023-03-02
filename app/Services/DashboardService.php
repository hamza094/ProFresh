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
     $user = Auth::user();

     $projects = $this->filterProjects($user);
                    
     return $this->respondWithSuccess([
      'projects'=>ProjectsResource::collection($projects->load('stage')),
      'projectsCount'=>$projects->count(),
       'message' => $projects->isEmpty() ? 'Sorry No Projects Found' : '',
      ]);
  }

     private function filterProjects($user)
     {
       switch (true) {
         case request()->filled('member'):
            return $user->members(true)->get();

         case request()->filled('abandoned'):
            return $user->projects()->onlyTrashed()->get();

         default:
            return $user->projects()->get();
      }
     }
    }
?>
