<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\TaskStatus as TaskStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\QueryBuilder\TaskQueryBuilder;

class Task extends Model
{
  use RecordActivity, SoftDeletes, HasFactory;

  protected $guarded=[];

  //protected $touches=['project'];

  protected $casts = [
    'due_at' => 'datetime',
];

  protected $deletedAt = 'archived_at';

  protected static function booted(): void
  {
    static::creating(function ($task) {
        if (!$task->status_id) {
            $task->status_id = 1; 
        }
    });

    static::forceDeleting(function ($task) {
        $task->activities()->delete();
    });

  }
 
  /**
     * The events that should be recorded.
     *
     * @var array<string>
  */
  protected static $recordableEvents = ['created','updated','deleted'];

  /**
   * Create a new Eloquent query builder for the model.
   */
  public function newEloquentBuilder($query): TaskQueryBuilder
  {
      return new TaskQueryBuilder($query);
  }

  public function path(): string
    {
      return "/api/v1/projects/{$this->project->slug}/tasks/{$this->id}";
    }

    /**
     * Get project associated to the task.
     *
     * @return BelongsTo<Project, Task>
     */
    public function project(): BelongsTo
    {
      return $this->belongsTo(Project::class);
    }

    /**
     * Get user who created task.
     *
     * @return BelongsTo<User, Task>
     */
    public function owner(): BelongsTo
    {
     return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the task assignees.
     *
     * @return BelongsToMany<User>
     */
    public function assignee(): BelongsToMany
    {
      return $this->belongsToMany(User::class);
    }

    public function assigneeBasic(): BelongsToMany
  {
    return $this->belongsToMany(User::class)
        ->select('users.id', 'users.name'); // no roles
  }

    /**
     * Get status associated to the task.
     *
     * @return BelongsTo<TaskStatus, Task>
    */
    public function status(): BelongsTo
    {
      return $this->belongsTo(TaskStatus::class, 'status_id');
    }
    
    public function state(): string
    {
        return $this->deleted_at ? 'trashed' : 'active';
    }
}
