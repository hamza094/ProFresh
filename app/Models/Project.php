<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectScore;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Activity;
use Illuminate\Support\Facades\Redis;
use Cviebrock\EloquentSluggable\Sluggable;
use Auth;

class Project extends Model
{
  use HasFactory, SoftDeletes, RecordActivity, Sluggable;

  protected $guarded=[];
  protected $dates = ['created_at'];
  protected $appends = ['IsSubscribedTo'];
  protected $with = ['scores'];

    /**
 * Return the sluggable configuration array for this model.
 *
 * @return array
 */
  public function sluggable(): array
  {
    return [
        'slug' => [
            'source' => 'name'
        ]
    ];
  }

  public function getRouteKeyName()
  {
    return 'slug';
  }

  public function path()
  {
      return "/api/v1/projects/{$this->slug}";
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
      return  $this->subscribers
              ->where('user_id', auth()->id());
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
