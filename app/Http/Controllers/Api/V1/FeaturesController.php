<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\Api\V1\FeatureService;
use App\Http\Resources\Api\V1\StageResource;
use App\Http\Resources\Api\V1\ProjectResource;
use App\Http\Resources\Api\V1\ProjectStageResource;
use F9Web\ApiResponseHelpers;
use App\Http\Controllers\Api\ApiController;
use App\Services\Api\V1\ProjectService;
use App\Http\Requests\Api\V1\StageRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use Illuminate\Http\JsonResponse;

class FeaturesController extends ApiController
{
    use ApiResponseHelpers;

    private $featureService;

    /**
      * Service For Project Feature
      * App\Service\FeatureService
      */
    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }

    /**
     * Update Project Stage.
     *
     * Updates the stage of a specified project. The new stage is provided in the request payload.
     *
     */
    public function stage(Project $project, StageRequest $request,ProjectService $service): JsonResponse
    {
        $validated = $request->validated();

        $this->featureService->updateStageStatus($project, $validated);

        $service->sendNotification($project);

        return response()->json([
         'message' => 'Project Stage Updated Successfully',
         'project' => new ProjectStageResource($project),
        ], 200);
    }

    public function export(Project $project)
    {
        //$this->featureService->excelExport($project);
        return Excel::download(new ProjectsExport($project), "Project $project->name.xls");
    }

}
