<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  use HasFactory;

protected $guarded=[];

protected $casts = ['changes' => 'array'];

  public function subject(){
    return $this->morphTo();
}

  public function user()
{
    return $this->belongsTo(User::class);
}

  public function project()
    {
        return $this->belongsTo('App\Project');
    }

}
