<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\FeatureService;
use App\Notifications\ProjectUpdated;
use Illuminate\Foundation\Validation\ValidatesRequests;


class FeaturesController extends ApiController
{
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
      ]);

      $project->update(request(['stage']));

      $this->featureService->recordStageUpdate($project);

      $this->sendNotification($project,new ProjectUpdated($project));

      if (request()->wantsJson()) {
          return response($project, 201);
      }
    }


   /**
     * Postpone Project Stage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function postponed(Project $project,Request $request)
    {
      $this->validate($request, [
          'postponed'=>'required',
          'stage'=>'required'
      ]);

      $project->update(request(['postponed','stage']));

      $this->sendNotification($project,new ProjectUpdated($project));

      if (request()->wantsJson()) {
          return response($project, 201);
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

    public function notes(Project $project,Request $request)
    {
       $this->validate($request, [
       'notes'=>'required',
      ]);

      $project->update(['notes'=>request('notes')]);

      $this->sendNotification($project,new ProjectUpdated($project));

      $this->recordScore($project,'Notes Updated',10);
    }

    public function export(Project $project)
    {
      $this->featureService->excelExport($project);
    }

}
