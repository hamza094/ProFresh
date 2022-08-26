<?php
namespace App\Services;
use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use Illuminate\Support\Facades\Redis;
use App\Helpers\ProjectHelper;
use F9Web\ApiResponseHelpers;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class FeatureService
{
  use ApiResponseHelpers;

   public function stageStatus($project,$request){

    if($this->hasRequest($request)){

     if($request->has('completed')){
       $this->stageCompletedOperation($project);
     }

     if($request->has('postponed')){
        $this->stagePostponedOperation($project,$request);
      }
        $project->stage()->dissociate();
    }

     if($request->stage > 0){
        $this->updateStage($project,$request);
     }

     $project->save();
     $project->update(['stage_updated_at'=>Carbon::now()]);
     return $project;
   }

     protected function hasRequest($request){
        return $request->has('completed') || $request->has('postponed');
     }


    protected function stageCompletedOperation($project){
      $project->update(['completed'=>true]);
      $project->removePostponedIfExists();
    }

    protected function stagePostponedOperation($project,$request){
       $project->update(['postponed'=>$request->postponed]);
       $project->markUncompleteIfCompleted();
    }

    protected function updateStage($project,$request){
      $project->markUncompleteIfCompleted();
      $project->removePostponedIfExists();
      $project->stage()->associate($request->stage);
    }


  public function excelExport($project)
  {
    return  (new ProjectsExport($project))->download("Project $project->name.xlsx");

    /*  return $this->respondWithSuccess([
     'message'=>$project->name . " file exported successfully",
   ]);*/

    //self::recordActivity($project,'export_project','default');
  }

  public function recordActivity($project,$activity,$info)
    {
      $project->recordActivity($activity,$info);
    }

}

?>
