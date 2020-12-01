<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\Appointment;
use App\User;
use Auth;

class AppointmentController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function store(Lead $lead,Request $request){

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
      'lead_id'=>$lead->id,
      'title'=>$request->title,
      'strtdt'=>$request->strtdt,
      'strttm'=>$request->strttm,
      'zone'=>$request->zone,
      'location'=>$request->location,
      'outcome'=>$request->outcome
    ]);
    $appointment->users()->attach($request->user);
  }

     public function show(Lead $lead,Request $request){
          return  $lead->appointments()->with('users')->get();
    }

    public function update(Lead $lead,Appointment $appointment,Request $request){

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

     public function destroy(Lead $lead,Appointment $appointment){
       $appointment->delete();
       $appointment->users()->detach();
     }

}
