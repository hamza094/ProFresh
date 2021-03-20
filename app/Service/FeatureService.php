<?php
namespace App\Service;
use App\Project;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use App\Mail\ProjectMail;



class FeatureService
{
	/**
    * Sms Message Method.
    *
    * @param  int  $recipients, string $message
   */
  public static function sendMessage($message, $recipients)
  {
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($recipients,
            ['from' => $twilio_number, 'body' => $message] );
  }

    /**
    * Excel Export And Record its Score and activity.
    *
    * @param  int  $project
     */
  public function excelExport($project)
  {
    return (new ProjectsExport($project))->download("project$project->id.xlsx");

    self::recordScoreAndActivity($project,'Excel Export',10,'export_project','default');
  }
  
   /**
    * Record Stage update with redis.
    *
    * @param  int  $project
     */
  public function recordStageUpdate($project)
  {
  	$redis = Redis::connection();
    $key = 'stage_update_' . $project->id;
    $value = (new \DateTime())->format("Y-m-d H:i:s");
    $redis->set($key, $value);
  }

  /**
    *Send Mail to member.
    *
    * @param  int  $project 
   */
  public function sendMailToMember($project,$request)
  {
    Mail::to($request['email'])->send(
        new ProjectMail($request->subject,$request->message));

  	self::recordScoreAndActivity($project,'Sent Mail',10,'mail_sent',$request->email);
  }

    /**
    * Record score and activity.
    *
    * @param  int  $project, char $message, int $count, char $activity, char $info
    */ 
    public function recordScoreAndActivity($project,$message,$count,$activity,$info)
    {
        $this->recordScore($project,$message,$count);

        $project->recordActivity($activity,$info);
    }
}

?>
