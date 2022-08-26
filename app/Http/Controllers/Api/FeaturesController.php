<?php

namespace App\Http\Controllers\Api;
use Auth;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\FeatureService;
use App\Http\Resources\StageResource;
use App\Notifications\ProjectUpdated;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\ProjectStageResource;
use F9Web\ApiResponseHelpers;
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
    $this->featureService=$featureService;
  }

    /**
     * Record Project Stage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
     public function stage(Project $project,Request $request)
     {
       $this->validate($request, [
          'stage'=>'sometimes|required',
          'postponed'=>'sometimes|required'
      ]);

      $this->featureService->stageStatus($project,$request);

      //$this->sendNotification($project,new ProjectUpdated($project));

      return $this->respondWithSuccess([
        'msg'=>'Project '.$project->slug.' Stage Updated Successfully',
        'project'=>new ProjectStageResource($project),
      ]);

    }

    public function export(Project $project)
    {
      //$this->featureService->excelExport($project);
        return Excel::download(new ProjectsExport($project), "Project $project->name.xls");
    }

}
