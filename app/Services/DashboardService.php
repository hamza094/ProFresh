<?php
namespace App\Services;

use App\Http\Resources\ProjectsResource;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Repository\DashBoardRepository;
use Auth;

class DashboardService
{
  use ApiResponseHelpers;

  protected $dashboardRepository;

   public function __construct(DashBoardRepository $dashboardRepository)
   {
        $this->dashboardRepository = $dashboardRepository;
   }

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

   public function fetchData()
   {
      $data = [];
       
    $data = $this->dashboardRepository->fetchData();

    $data['active_invited_projects'] = (int) $data['active_invited_projects'];
    $data['total_projects'] = (int) $data['total_projects'];
    $data['active_projects'] = (int) $data['active_projects'];
    $data['trashed_projects'] = (int) $data['trashed_projects'];

       return $data;
    }

    }
?>
