<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProjectScore;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Activity;
use Illuminate\Support\Facades\Redis;
use Auth;


class Project extends Model
{
  use SoftDeletes;
  use RecordActivity;
  protected $guarded=[];
  protected $dates = ['created_at'];
  protected $appends = ['IsSubscribedTo'];

    public function path()
    {
        return "/api/projects/{$this->id}";
    }

    protected static function boot()
    {
     parent::boot();
     static::deleting(function($project) {
        $project->activity()->delete();
    });
    }

    public function scores(){
        return $this->hasMany(ProjectScore::class);
    }

    public function addScore($message,$point)
    {
      return ProjectScore::create([
            'project_id'=>$this->id,
            'message'=>$message,
            'point'=>$point
      ]);
    }

    public function owner()
    {
     return $this->belongsTo(User::class,'user_id');
    }

   public function user()
   {
     return $this->belongsTo(User::class,'user_id');
   }

   public function group()
   {
    return $this->belongsTo(Group::class,'group_id');
   }

    public function subscribers()
    {
      return $this->hasMany(Subscribe::class);
    }

    public function getIsSubscribedToAttribute()
    {
      return  $this->subscribers()
              ->where('user_id', auth()->id())
              ->exists();
    }

    public function subscribe($userId = null)
    {
      $this->subscribers()->create([
        'user_id'=>$userId ?: auth()->id()
    ]); 
    return $this;
    }

    public function unsubscribe($userId = null)
    {
      $this->subscribers()->where('user_id', $userId ?: auth()->id())->delete();
    }

    public function stageupdate()
     {
       $redis = Redis::connection();
       return $redis->get('stage_update_' . $this->id);
     }

    public function tasks()
    {
      return $this->hasMany(Task::class);
    }

    public function addTask($tasks)
    {
       return $this->tasks()->create([
         'body'=> $tasks
       ]);
    }

    public function invite(User $user)
    {
      return $this->members()->attach($user);
    }

   public function appointments()
   {
     return $this->hasMany(Appointment::class);
   }

    public function members()
    {
      return $this->belongsToMany(User::class,'project_members')->withPivot('active');
    }

   public function activeMembers()
    {
      return $this->members()->where('active',1);
    }

}
