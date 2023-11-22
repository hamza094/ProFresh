<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordActivity;

class Stage extends Model
{
    use HasFactory, RecordActivity;

    protected $guarded=[];

    public function projects(){
      return $this->hasMany(Project::class);
    }

    public function project(){
      return $this->belongsTo(Project::class);
   }

}
