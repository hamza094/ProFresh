<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use RecordActivity,HasFactory;

    protected $casts = ['delivered_at'=>'datetime'];

    protected $guarded=[];

    protected static $recordableEvents = ['created'];

    public function project()
    {
      return $this->belongsTo(Project::class);
    }

    public function users()
    {
       return $this->belongsToMany(User::class);
    }

    public function scopeMessageScheduled($query){
       $query
           ->where('delivered',false)
           ->whereNotNull('delivered_at')
           ->where('delivered_at','<=',Carbon::now());
    }

}
