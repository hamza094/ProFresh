<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
  use HasFactory;
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
     static::deleted(function($appointment) {
        $appointment->users()->detach();
    });
    }





}
