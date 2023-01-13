<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function projects(){
      return $this->hasMany(Project::class);
    }

    public function project(){
      return $this->belongsTo(Project::class);
   }

}
