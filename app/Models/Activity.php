<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Activity extends Model
{
  use HasFactory,BelongsToUser;

protected $guarded=[];

protected $casts = ['changes' => 'array'];

  public function subject(){
    return $this->morphTo();
}

  public function project()
    {
        return $this->belongsTo('App\Project');
    }

}
