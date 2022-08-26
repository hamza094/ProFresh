<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Message extends Model
{
    use HasFactory;

    protected $casts = ['delivered_at'=>'datetime'];

    protected $guarded=[];

    public function project()
    {
      return $this->belongsTo(Project::class);
    }

    public function users()
    {
       return $this->belongsToMany(User::class);
    }

    public function scopeMessageScheduled($query){
       $query->where('delivered',false)
       ->whereNotNull('delivered_at')
       ->where('delivered_at','<=',Carbon::now());
    }

}
