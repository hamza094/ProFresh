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

  protected static function booted()
  {
    static::creating(function ($task) {
        if (!$task->status_id) {
            $task->status_id = 1; // Assign the default status ID here
        }
    });
  }

  //protected static $recordableEvents = ['created','updated'];

  public function path()
    {
      return "/api/v1/projects/{$this->project->slug}/task/{$this->id}";
    }

    public function project(){
      return $this->belongsTo(Project::class,'project_id');
   }

   public function assignee()
   {
     return $this->belongsToMany(User::class);
   }

    public function status()
    {
      return $this->belongsTo(TaskStatus::class,'status_id');
    }

}
