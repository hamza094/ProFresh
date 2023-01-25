<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Helpers\ProjectHelper;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\Bus;
use Illuminate\Validation\ValidationException;

class MessageService
{
  use ApiResponseHelpers;

  public function checkOptionSelect($request)
  {
    if(!$request->mail  && !$request->sms){
      throw ValidationException::withMessages([
       'option'=>'Please choose any options.',
     ]);
    }
  }

  public function send($project,$users)
  {
    $response = '';

    $types = ['mail', 'sms'];
    
    $send_or_schedule = request()->filled('date') ? 'Scheduled' : 'Sent';

    foreach ($types as $type) {
        if (request()->boolean($type)) {
            $message = $this->messageCreate($project, $type, $users);
            $this->sendOrScheduledMessage($project, $message);
        }
    }

    $response = "Messages {$send_or_schedule} Successfully";

    return response()->json(['msg' => $response], 200);
  }

  public function messageCreate($project,$type,$users)
  {
    $message=Message::create([
      'project_id'=>$project->id,
       'type'=>$type,
       'message'=>request()->message,
     ]);

     if($message->type == 'mail'){
       $message->subject =request()->get('subject');
       $message->save();
     }

     $message->users()->attach($users);

     return $message;
  }

  public function sendOrScheduledMessage($project,$message)
  {
    request()->date ?
    $this->scheduledMessage($message) :
    $this->sendNow($project,$message);
  }

  public function sendNow($project,$message)
  {
     $message->type == 'mail' ? $job='\App\Jobs\MailMessage':
     $job='\App\Jobs\SmsMessage';

      $jobs = $message->users
        ->map(function($user) use ($project,$message,$job) {
              return new $job($project,$message,$user);
      });

     $batch=Bus::batch($jobs)
    ->allowFailures()
    ->then(function () use ($message){
       $message->delivered=true;
       $message->save();
       //notify user on batch success
     })->catch(function (Batch $batch, Throwable $e) {
    // notify on job failure
    })->dispatch();

     $message->update([
       'batch_id'=>$batch->id
     ]);
  }

  public function scheduledMessage($message)
  {
    $this->saveMessageDateAndTime($message);
  }

  private function saveMessageDateAndTime($message)
  {
    $datetime=new \DateTime(request()->date.' ' .request()->time);

    $formattedTime=$datetime->format('Y-m-d H:i:s');

    $message->delivered_at=\Timezone::convertFromLocal($formattedTime);

    $message->save();
  }

}

?>
