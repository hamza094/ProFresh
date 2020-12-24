<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use RecordActivity;

    protected $guarded=[];

    protected $touches=['project'];

  protected $casts=['completed'=>'boolean'];

  protected static $recordableEvents = ['created','updated','deleted'];


  public function path()
    {
        return "/api/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function project(){
      return $this->belongsTo(Project::class,'project_id');
    }

    public function Projectpath()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function activity(){
       return $this->morphMany(Activity::class,'subject')->latest();
   }

    public function complete(){
      $this->update(['completed'=>true]);
   }

   public function incomplete(){
      $this->update(['completed'=>false]);
  }

}
