<?php

namespace App\Models;

//use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use App\Models\Activity;
use Illuminate\Support\Facades\Redis;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Traits\BelongsToUser;
use Carbon\Carbon;
use Auth;

class Project extends Model
{
  use HasFactory, SoftDeletes, Sluggable,BelongsToUser;

  protected $guarded=[];
  protected $dates = ['created_at'];
  protected $with = ['tasks','stage'];
  protected $casts = ['stage_updated_at'=>'datetime'];

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
        //$project->activity()->delete();
    });
    }

   public function stage()
   {
     return $this->belongsTo(Stage::class,'stage_id');
   }

   public function group()
   {
     return $this->belongsTo(Group::class,'group_id');
   }

    public function tasks()
    {
      return $this->hasMany(Task::class)->latest();
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

    public function members()
    {
      return $this->belongsToMany(User::class,'project_members')->withPivot('active');
    }

   public function activeMembers()
  {
      return $this->members()->where('active',true)->get();
  }

  public function activeMembersData()
 {
     return $this->members()->where('active',true)->select('name','email','user_id')->get()->makeHidden('pivot');
 }

    public function markUncompleteIfCompleted(){
      if($this->completed == true){
        $this->update(['completed'=>false]);
      }
    }

    public function removePostponedIfExists(){
      if($this->postponed != null){
         $this->update(['postponed'=>null]);
      }
    }

    public function tasksReachedItsLimit(){
      return $this->tasks->count() == config('project.taskLimit');
    }

    public function currentStatus(){
     return 'cold';
   }

   public function scopePastAbandonedLimit($query){
      $query->where( 'deleted_at', '<', Carbon::now()->subDays(config('project.abandonedLimit')));
   }

}
