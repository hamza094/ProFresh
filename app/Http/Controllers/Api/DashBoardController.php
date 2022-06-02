<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Project;
use App\Services\DashboardService;
use App\Http\Resources\ProjectsResource;

class DashboardController extends ApiController
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

    public function userprojects()
    {
       return $this->dashboardService->getUserProjects();
    }

}
