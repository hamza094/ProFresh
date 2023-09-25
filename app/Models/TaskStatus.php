<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $table = 'statuses';

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
