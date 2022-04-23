<?php

namespace App\Http\Controllers\Api;
use Auth;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\FeatureService;
use App\Notifications\ProjectUpdated;
use App\Http\Resources\ProjectResource;
use F9Web\ApiResponseHelpers;
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
          'stage'=>'required',
          'postponed'=>'sometimes|required'
      ]);

      $this->featureService->stageStatus($project,$request);

      //$this->featureService->recordStageUpdate($project);

      //$this->sendNotification($project,new ProjectUpdated($project));

      if (request()->wantsJson()) {
          return response(new ProjectResource($project), 201);
      }
    }

    public function mail(Project $project,Request $request)
    {
        $this->featureService->sendMailToMember($project,$request);
    }


     /**
     * Send SMS To Specified Number.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function sms(Project $project,Request $request)
    {
      $this->validate($request, [
       'mobile'=>'required|numeric',
       'sms'=>'required'
      ]);

      $this->featureService->sendMessage($request->sms,$request->mobile);

      $this->featureService->recordScoreAndActivity($project,'Sent Sms',10,'sms_project',
      $request->mobile);
    }

    public function export(Project $project)
    {
      $this->featureService->excelExport($project);
    }

}
