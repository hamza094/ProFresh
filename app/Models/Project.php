<?php

namespace App\Models;

use App\Traits\RecordActivity;
use App\Actions\ScoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Redis;
use Cviebrock\EloquentSluggable\Sluggable;
use Carbon\Carbon;
use Auth;

class Project extends Model
{
  use RecordActivity, HasFactory, SoftDeletes, Sluggable;

  protected $guarded=[];
  protected $dates = ['created_at'];
  protected $casts = ['stage_updated_at'=>'datetime'];
  protected static $recordableEvents = ['created','updated','deleted','restored'];

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

   public function user(){
       return $this->belongsTo(User::class);
   }

   protected static function boot()
   {
    parent::boot();
    static::forceDeleted(function($project) {
       $project->activities()->delete();
   });
   }

   public function stage()
   {
     return $this->belongsTo(Stage::class);
   }

    public function tasks()
    {
      return $this->hasMany(Task::class)->latest();
    }

    public function messages()
    {
      return $this->hasMany(Message::class);
    }

    public function addTask($tasks)
    {
       return $this->tasks()->create([
         'body'=> $tasks
       ]);
    }

    public function addTasks($tasks)
    {
      return $this->tasks()->createMany($tasks);   
    }

    public function invite(User $user)
    {
      return $this->members()->attach($user);
    }

    public function members()
    {
      return $this->belongsToMany(User::class,'project_members')
                  ->withPivot('active');
    }

    public function activeMembers()
    {
      return $this
            ->members()
            ->wherePivot('active',true);
    }

    public function conversations()
    {
      return $this->hasMany(Conversation::class);
    }

    public function markUncompleteIfCompleted(){
      if($this->completed){
        $this->update(['stage_id'=>0,'completed'=>false]);
      }
    }

    public function removePostponedIfExists()
    {
      if (!is_null($this->postponed)) {
        $this->update(['postponed' => null]);
      }
    }

    public function tasksReachedItsLimit(){
      return $this->tasks->count() == config('app.project.taskLimit');
    }

   public function score()
   {
     $scoreAction = new ScoreAction($this);

     return $scoreAction->calculateTotal(); 
   }

    public function status()
    {
      $scoreAction = new ScoreAction($this);

      return $scoreAction->getStatus(); 
    }

   public function scopePastAbandonedLimit($query)
   {
     $abandonedLimit = config('app.project.abandonedLimit');

      $query->where( 'deleted_at', '<', Carbon::now()
             ->subDays($abandonedLimit));
   }

   public function scheduledMessages(){
      return $this
      ->messages()
      ->where('delivered',false)
      ->whereNotNull('delivered_at')
      ->where('delivered_at','>',Carbon::now())
      ->with('users:name')
      ->get();
   }

}
