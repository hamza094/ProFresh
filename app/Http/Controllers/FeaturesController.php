<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectScore;
use Illuminate\Http\Request;
use App\Service\FeatureService;


class FeaturesController extends Controller
{ 

  private $featureService;

    /**
    /* Service For Project Feature 
     * App\Service\FeatureService
    */

  public function __construct(FeatureService $featureService){
   $this->featureService=$featureService;
  }

    /**
     * Record Project Stage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */

     public function stage(Project $project,Request $request){

     $this->authorize('access',$project);

      $this->validate($request, [
          'stage'=>'required',
      ]);

      $project->update(request(['stage']));

      $this->featureService->recordStageUpdate($project);

      $this->sendNotificationToMember($project);

      if (request()->wantsJson()) {
          return response($project, 201);
      }
    }


   /**
     * Postpon Project Stage.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function postponed(Project $project,Request $request)
    {
      
      $this->authorize('access',$project);

      $this->validate($request, [
          'postponed'=>'required',
          'stage'=>'required'
      ]);

      $project->update(request(['postponed','stage']));

      $this->sendNotificationToMember($project);

      if (request()->wantsJson()) {
          return response($project, 201);
      }
   }

    /**
     * Send Project Mail.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */    
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

    /**
     *Project Notes.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */

    public function notes(Project $project,Request $request)
    {
       $this->validate($request, [
       'notes'=>'required',
      ]);
      $this->authorize('access',$project);

      $project->update(['notes'=>request('notes')]);

      $this->sendNotificationToMember($project);

     if(!$project->scores()->where('message','Notes Updated')->exists()){
      $project->addScore('Notes Updated',10);
    }

}

    /**
     * Download Project Data Excel Export.
     *
     * @param  int  $project
     */
    public function export(Project $project)
    {
      $this->featureService->excelExport($project);
    }

}
