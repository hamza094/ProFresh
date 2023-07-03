<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use RecordActivity, HasFactory;

  protected $guarded=[];

  protected $touches=['project'];

  protected $casts=['completed'=>'boolean'];

  //protected static $recordableEvents = ['created','updated'];

  public function path()
    {
      return "/api/v1/projects/{$this->project->slug}/task/{$this->id}";
    }

    public function complete()
    {
      $this->update(['completed'=>true]);
    }

    public function incomplete()
    {
      $this->update(['completed'=>false]);
    }

    public function project(){
      return $this->belongsTo(Project::class);
   }

   public function assign()
   {
     return $this->belongsToMany(User::class);
   }

    public function status()
    {
      return $this->belongsTo(TaskStatus::class);
    }

}
