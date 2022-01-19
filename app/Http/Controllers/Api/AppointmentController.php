<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\Services\AppointmentService;

class AppointmentController extends ApiController
{
  private $appointmentService;

  /**
    * Service For Appointment
    *
    * App\Service\Appointment Service
    */
  public function __construct(AppointmentService $appointmentService)
  {
    $this->appointmentService=$appointmentService;
  }

  public function index(Project $project,Request $request)
  {
    return  $project->appointments()->with('users')->get();
  }

  public function store(Project $project,AppointmentRequest $request)
  {

    $appointment=$project->appointments()->create($request->validated());

    $this->appointmentService->performAppointmentRelatedTasks($project,$appointment);
  }

    public function update(Project $project,Appointment $appointment,AppointmentRequest
      $request)
    {
      $appointment->update($request->validated());

      $this->appointmentService->
      performRelatedOperation($project,$request,$appointment);
    }

     public function destroy(Project $project,Appointment $appointment)
     {
       $appointment->delete();

       $appointment->activity()->delete();

       $project->recordActivity('deleted_appointment',$appointment->title);
     }
}
