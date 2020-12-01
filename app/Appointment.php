<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  protected $guarded=[];

  public function lead(){
    return $this->belongsTo(Lead::class,'lead_id');
  }

  public function users(){
    return $this->belongsToMany(User::class);
  }
}
