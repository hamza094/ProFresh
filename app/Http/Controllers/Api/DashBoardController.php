<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Project;
use App\Services\DashboardService;
use App\Http\Resources\ProjectsResource;

class DashBoardController extends ApiController
{
  private $DashboardService;

  /**
    * Service For Dashboard Feature
    *
    * App\Service\DashboardService
    */

    public function __construct(DashboardService $dashboardService)
    {
       $this->dashboardService=$dashboardService;
    }

    public function userprojects(Request $request)
    {
       return  $this->dashboardService->userProjectsFilters($request);
    }

    public function projectcount()
    {
       $projectcount=auth()->user()->projects->count();
       return response()->json($projectcount);
    }
}
