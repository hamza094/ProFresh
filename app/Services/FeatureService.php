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
     $nullStage=0;

     if($request->stage == $nullStage){

     $this->stageCompletedOperation($project);

     if($request->has('postponed')){
       $this->stagePostponedOperation($project,$request);
     }
        $project->stage()->dissociate();
     }

     if($request->stage > $nullStage){
       $this->updateStage($project,$request);
     }

     $project->save();
     $project->update(['stage_updated_at'=>Carbon::now()]);
     return $project;
   }

    protected function stageCompletedOperation($project){
      $project->update(['completed'=>true]);
      //$project->removePostponedIfExists();
    }

    protected function stagePostponedOperation($project,$request){
       //$project->markUncompleteIfCompleted();
       $project->update(['postponed'=>$request->postponed]);
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

    self::recordScoreAndActivity($project,'Excel Export',10,'export_project','default');
  }

  public function recordStageUpdate($project)
  {
  	$redis = Redis::connection();
    $key = 'stage_update_' . $project->id;
    $value = (new \DateTime())->format("Y-m-d H:i:s");
    $redis->set($key, $value);
  }

  public function sendMailToMember($project,$request)
  {
    Mail::to($request['email'])->send(
        new ProjectMail($request->subject,$request->message));

  	self::recordScoreAndActivity($project,'Sent Mail',10,'mail_sent',$request->email);
  }

  public function recordScoreAndActivity($project,$message,$count,$activity,$info)
    {
      ProjectHelper::recordScore($project,$message,$count);

      $project->recordActivity($activity,$info);
    }
}

?>
