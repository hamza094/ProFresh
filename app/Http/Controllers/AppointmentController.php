<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Appointment;
use App\User;
use Auth;

class AppointmentController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function store(Project $project,Request $request){

    $this->validate($request, [
        'title'=>'required',
        'strtdt'=>'required',
        'strttm'=>'required',
        'zone'=>'required',
        'location'=>'required',
        'outcome'=>'required',
        //'user'=>'required'
    ]);

    $appointment=Appointment::create([
      'project_id'=>$project->id,
      'title'=>$request->title,
      'strtdt'=>$request->strtdt,
      'strttm'=>$request->strttm,
      'zone'=>$request->zone,
      'location'=>$request->location,
      'outcome'=>$request->outcome
    ]);
    $appointment->users()->attach($request->user);
  }

     public function show(Project $project,Request $request){
          return  $project->appointments()->with('users')->get();
    }

    public function update(Project $project,Appointment $appointment,Request $request){

      $this->validate($request, [
          'title'=>'required',
          'strttm'=>'required',
          'zone'=>'required',
          'location'=>'required',
          'outcome'=>'required',
      ]);

      $appointment->update([
            'title'=>request('title'),
            'strttm'=>request('strttm'),
            'zone'=>request('zone'),
            'location'=>request('location'),
            'outcome'=>request('outcome')
          ]);

        if($request->filled('strtdt')){
          $appointment->update(['strtdt'=>request('strtdt')]);
        }else{
          $appointment->update(['strtdt'=>$appointment->strtdt]);
        }

          if ($appointment->users->contains(request('user'))) {
            $appointment->users()->detach(request('user'));
           }else{
           $appointment->users()->attach(request('user'));
         }
    }

     public function destroy(Project $project,Appointment $appointment){
       $appointment->delete();
       $appointment->users()->detach();
     }

}
