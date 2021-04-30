<?php
namespace App\Services;
use App\Project;
use Illuminate\Http\Request;
use App\Notifications\ProjectAppointment;
use App\Activity;
use App\User;

class AppointmentService extends \App\Http\Controllers\Controller
{
  /**
    * Attach user, send notification, record score.
    *
    * @param  int  $project, char $appointment
    */ 
  public function performAppointmentRelatedTasks($project,$appointment)
  {
    $appointment->users()->attach(request('user'));

    $this->sendNotification($project,new ProjectAppointment($project));

    $this->recordScore($project,'Appointment Added',10);
  }

  public function performRelatedOperation($project,$request,$appointment)
  {
    $appointment->update(['strtdt'=>$appointment->strtdt]);

      if($request->filled('strtdt'))
      {
        $appointment->update(['strtdt'=>request('strtdt')]);
      }

     $this->attachDetachUser($project,$request,$appointment);  
  }

  /**
    * Attach detach user to appointment.
    *
    * @param  int  $project, int $appointment
    */ 
  protected function attachDetachUser($project,$request,$appointment)
  {
    if($request->filled('user')){

      if ($appointment->users->contains(request('user'))) {
                
      $appointment->users()->detach(request('user'));

      $this->RecordActivity($appointment,$project,'userdetach_appointment');
     }else{
      $appointment->users()->attach(request('user'));

      $this->RecordActivity($appointment,$project,'userattach_appointment');
     }
    }
  }

  /**
    * Record appointment with user info.
    *
    * @param  int  $project, int $appointment, string $description
    */
  protected function RecordActivity($appointment,$project,$description)
  {
    $user=User::find(request('user'));

    $project->activity()->create([
      'user_id'=>auth()->id(),
      'subject_type'=>'App\Appointment',
      'subject_id'=>$appointment->id,
      'description'=>'userattach_appointment',
      'detail'=>$user->name.'/_/'.$user->id,
      ]);
    }
}

?>