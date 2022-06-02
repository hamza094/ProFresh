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
     $projects=$this->getFilteredProjects(Auth::user());

    $message='';

    if($projects->count() == 0){
       $message='Sorry No Projects Found';
    }

      return $this->respondWithSuccess([
      'projects'=>ProjectsResource::collection($projects),
      'projectsCount'=>$projects->count(),
      'message'=>$message
      ]);
  }

     private function getFilteredProjects($user)
     {
       if(request()->filled('member'))
       {
          return $user->members;
       }

       if(request()->filled('abandoned'))
       {
          return $user->projects()->onlyTrashed()->get();
       }

        return $user->projects()->get();
     }

    }
?>
