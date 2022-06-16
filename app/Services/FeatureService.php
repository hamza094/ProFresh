<?php
namespace App\Services;
use App\Models\Project;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Mail\ProjectMail;
use App\Helpers\ProjectHelper;
use Carbon\Carbon;

class FeatureService
{
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

  public static function sendMessage($message, $recipients)
  {
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($recipients,
            ['from' => $twilio_number, 'body' => $message] );
  }

  public function excelExport($project)
  {
    return (new ProjectsExport($project))->download("project$project->id.xlsx");

    self::recordActivity($project,'export_project','default');
  }

  public function sendMailToMember($project,$request)
  {
    Mail::to($request['email'])->send(
        new ProjectMail($request->subject,$request->message));

  	self::recordActivity($project,'mail_sent',$request->email);
  }

  public function recordActivity($project,$activity,$info)
    {
      $project->recordActivity($activity,$info);
    }
}

?>
