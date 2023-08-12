<?php

namespace App\Models;

use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
  //use RecordActivity,
  use SoftDeletes, HasFactory;

  protected $guarded=[];

  protected $touches=['project'];

  protected $deletedAt = 'archived_at';

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
      return "/api/v1/projects/{$this->project->slug}/tasks/{$this->id}";
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

    public function scopeArchived($query)
    {
        return $query->onlyTrashed()->with('status')->get();
    }

    public function scopeActive($query)
    {
        return $query->with('status')->get();
    }

}
