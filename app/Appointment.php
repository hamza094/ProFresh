<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  use RecordActivity;

  protected $guarded=[];

  protected static $recordableEvents = ['created','updated','deleted'];


  public function project(){
    return $this->belongsTo(Project::class,'project_id');
  }

  public function users(){
    return $this->belongsToMany(User::class);
  }

  public function activity(){
     return $this->morphMany(Activity::class,'subject')->latest();
 }

  protected static function boot()
    {
     parent::boot();
     static::deleting(function($appointment) {
        $appointment->users()->detach();
        $appointment->activity()->delete();
    });
    }





}
