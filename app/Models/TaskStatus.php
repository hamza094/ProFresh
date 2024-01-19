<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordActivity;

class TaskStatus extends Model
{
    use HasFactory,RecordActivity;

    protected $guarded=[];

    protected $table = 'statuses';

    protected static function boot()
    {
        parent::boot();

          static::deleting(function ($taskStatus) {
            $taskStatus->tasks()->update(['status_id' => null]);
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
