<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $table = 'statuses';

    protected static function boot(): void
    {
        parent::boot();

          static::deleting(function ($taskStatus) {
            $taskStatus->tasks()->update(['status_id' => null]);
        });
    }

    /**
     * Get all tasks associated to TaskStatus.
     *
     * @return HasMany<Task>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'status_id');
    }
    
    /**
     * Get user who created TaskStatus.
     *
     * @return BelongsTo<User, TaskStatus>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
