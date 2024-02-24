<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserActivitiesResource;
use App\Services\DashboardService;
use App\Http\Resources\ProjectsResource;
use Carbon\Carbon;

class ProjectDashboardController extends Controller
{
    private $DashboardService;

    public function __construct(DashboardService $dashboardService)
    {
       $this->dashboardService=$dashboardService;
    }

    public function userprojects()
    {
       return $this->dashboardService->getUserProjects();
    }

    public function activities()
    {
        $activities = Activity::query()
         ->where('user_id', auth()->id())
         ->with(['subject', 'project' => function ($query) {
              $query->withTrashed();
           }, 'project.stage'])
        ->get();

        return UserActivitiesResource::collection($activities);       
    }

    public function data(Request $request)
    {     
      $data = [];

    $data = $this->dashboardService->fetchData();

      return response()->json(['projectsData'=>$data]);
    }

}
