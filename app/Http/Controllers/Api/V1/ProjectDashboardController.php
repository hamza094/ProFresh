<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Activity;
use Illuminate\Http\JsonResponse;
use App\Repository\UserTasksDataRepository;
use App\Http\Resources\Api\V1\UserActivitiesResource;
use App\Services\Api\V1\DashboardService;
use App\Http\Resources\Api\V1\ProjectsResource;
use App\Http\Resources\Api\V1\UserTasksResource;
use Carbon\Carbon;
use App\Http\Requests\Api\V1\DashboardProjectRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;


class ProjectDashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Get paginated list of user's projects with filters
     * 
     * List and filter user's projects. Supports pagination with defined items per page.
     *
     * @response AnonymousResourceCollection<LengthAwarePaginator<ProjectsResource>>
     * 
     */
    public function userProjects(DashboardProjectRequest $request): JsonResponse
    {
        $projects = $this->dashboardService->getUserProjects($request);

        return response()->json([
            'projects' => ProjectsResource::collection($projects)->paginate(config('app.project.items_limit')),
            'projectsCount' => $projects->count(),
            'message' => $projects->isEmpty() ? 'Sorry No Projects Found' : '',
        ], 200);
    }

    /**
     * Get recent active projects
     * 
     */
    public function dashboardProjects(): JsonResponse
    {
        $projects = $this->dashboardService->getDashboardProjects();
        
        $projectsResource = ProjectsResource::collection($projects);

        return response()->json([
            'projects' => $projectsResource,
            'projectsCount' => $projects->count(),
            'message' => $projects->isEmpty() ? 'No active projects found' : '',
        ], 200);
    }


    /**
     * Get user project activities
     * 
     */
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


    public function data(Request $request): JsonResponse
    {
        $data = $this->dashboardService->fetchData();

        return response()->json(['projectsData' => $data]);
    }

    public function tasksData(UserTasksDataRepository $repository, Request $request)
    {
        $tasks = $repository->getTasks(auth()->id(), $request);

        $appliedFilters = $repository->appliedFilters($request);

        return [
            'tasks' => UserTasksResource::collection($tasks),
            'applied_filters' => $appliedFilters,
        ];
    }
}
