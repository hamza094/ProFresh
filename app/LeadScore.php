<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadScore extends Model
{
    protected $guarded=[];

    public function lead(){
        return $this->belongsTo(Lead::class,'lead_id');
    }
}
