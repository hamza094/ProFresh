<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

     /**
     * Get the users associated to message.
     *
     * @return BelongsToMany<User>
     */
    public function users(): BelongsToMany
    {
       return $this->belongsToMany(User::class);
    }

    public function scopeMessageScheduled($query){
       $query
           ->where('delivered',false)
           ->whereNotNull('delivered_at')
           ->whereDate('delivered_at','<=',Carbon::now());
    }

}
