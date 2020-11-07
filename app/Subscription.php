<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded=[];

    public function lead(){
      return $this->belongsTo(Lead::class,'lead_id');
    }
}
