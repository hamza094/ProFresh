<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Resources\Api\V1\Admin\ActivitiesResource;
use App\Models\Activity;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use App\Services\Api\V1\Admin\DashboardService;


class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function backup()
    {
       try {
               Artisan::call('backup:clean');
            Artisan::call('backup:run');
            return response()->json(['message' => 'Backup process started']);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function activities()
    {
        $activities=Activity::with('user','subject','project')->latest()->limit(15)->get();

        return ActivitiesResource::collection($activities);
    }

   public function data(Request $request)
   {     
    $data = [];

    $startDate = Carbon::now()->subMonths(11)->startOfMonth();
    $endDate = Carbon::now()->endOfMonth();

    $data = $this->dashboardService->fetchDataForMonths($startDate, $endDate);

      return response()->json($data);
    }
}
