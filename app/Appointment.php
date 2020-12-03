<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  protected $guarded=[];

  public function project(){
    return $this->belongsTo(Project::class,'project_id');
  }

  public function users(){
    return $this->belongsToMany(User::class);
  }
}
