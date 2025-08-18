<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meeting extends Model
{
    use RecordActivity, HasFactory;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'join_url',
        'start_url',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'encrypted',
        'join_url' => 'encrypted',
        'start_url'=>'encrypted',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, self>
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Project, self>
     */
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @param Builder<\App\Models\Meeting> $query
     * @return Builder<\App\Models\Meeting>
     */
    public function scopePrevious(Builder $query): Builder
    {
        return $query->where('start_time', '<', Carbon::now());
    }

    /**
     * @param Builder<\App\Models\Meeting> $query
     * @return Builder<\App\Models\Meeting>
     */
    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('start_time', '>=', Carbon::now());
    }
}
