<?php
namespace App\Service;
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

    $notification = new ProjectAppointment($project);

    $this->sendNotificationToMember($project,$notification);

    $this->recordScore($project,'Appointment Added',10);
  }

  /**
    * Attach detach user to appointment.
    *
    * @param  int  $project, int $appointment
    */ 
  public function attachDetachUser($project,$request,$appointment)
  {
      if($request->filled('user')){

            $appointment->users()->attach(request('user'));

           $this->RecordActivity($project,'userattach_appointment');

            if ($appointment->users->contains(request('user'))) {
                
            $appointment->users()->detach(request('user'));

            $this->RecordActivity($project,$user,'userdetach_appointment');

           }
        }
  }

  /**
    * Record appointment with user info.
    *
    * @param  int  $project, int $appointment, string $description
    */
  protected function RecordActivity($project,$user,$description)
  {
    $user=User::find(request('user'));
     Activity::create([
             'user_id'=>auth()->id(),
             'project_id'=>$project->id,
             'subject_type'=>'App\Appointment',
             'subject_id'=>$appointment->id,
             'description'=>'userattach_appointment',
             'detail'=>$user->name.'/_/'.$user->id,
           ]);
    }

}

?>