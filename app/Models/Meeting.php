<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meeting extends Model
{
    use HasFactory;

    protected $guarded=[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'join_url',
        'start_url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'password' => 'encrypted',
        'join_url' => 'encrypted',
        'start_url'=>'encrypted',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function scopePrevious(Builder $query): Builder
    {
        return $query->where('start_time', '<', Carbon::now());
    }


    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('start_time', '>=', Carbon::now());
    }
}
