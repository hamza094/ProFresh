<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\RecordActivity;

class Stage extends Model
{
    use HasFactory, RecordActivity;

    protected $guarded=[];

    public function projects(): HasMany
    {
      return $this->hasMany(Project::class);
    }

    public function project(){
      return $this->belongsTo(Project::class);
   }

   public function user()
    {
        return $this->belongsTo(User::class);
    }

}
