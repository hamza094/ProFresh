<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;
use App\Traits\BelongsToProject;

class Activity extends Model
{
  use HasFactory,BelongsToUser,BelongsToProject;

  protected $guarded=[];

  protected $casts = ['changes' => 'array'];

  public function subject(){
    return $this->morphTo();
}

}
