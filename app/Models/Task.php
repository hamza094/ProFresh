<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use App\Enums\TaskStatus as TaskStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
  use RecordActivity, SoftDeletes, HasFactory;

  protected $guarded=[];

  protected $touches=['project'];

  protected $casts = [
    'due_at' => 'datetime',
];

  protected $deletedAt = 'archived_at';

  protected static function booted()
  {
    static::creating(function ($task) {
        if (!$task->status_id) {
            $task->status_id = 1; 
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

    public function owner()
    {
     return $this->belongsTo(User::class,'user_id');
    }

   public function assignee()
   {
     return $this->belongsToMany(User::class);
   }

     public function status()
    {
      return $this->belongsTo(TaskStatus::class, 'status_id');
    }

    public function scopeArchived($query)
    {
        return $query->onlyTrashed()->with('status')->get();
    }

    public function scopeActive($query)
    {
        return $query->with('status')->get();
    }

    public function scopeDueForNotifications($query){
       $query
        ->whereNotNull(['notified','due_at'])
        ->where('due_at', '>=', now())
        ->where('notify_sent', false);
    }

    public function state(){
      return $this->deleted_at ? 'trashed' : 'active';
   }

    public function scopeCompleted($query)
    {
        return $query->where('status_id', TaskStatusEnum::COMPLETED);
    }

     // Scope for remaining tasks
    public function scopeRemaining($query)
    {
        return $query->where('due_at', '>=', now())
                     ->where('status_id', '!=', TaskStatusEnum::COMPLETED);
    }

    // Scope for overdue tasks
    public function scopeOverdue($query)
    {
        return $query->where('due_at', '<', now())
                     ->where('status_id', '!=', TaskStatusEnum::COMPLETED);
    }
}
