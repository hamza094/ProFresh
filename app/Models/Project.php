<?php

namespace App\Models;

use App\Traits\RecordActivity;
use App\Actions\ScoreAction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Redis;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Enums\ScoreValue;
use Carbon\Carbon;
use Auth;

class Project extends Model
{
    use RecordActivity;
    use HasFactory;
    use SoftDeletes;
    use Sluggable;

    protected $guarded = [];
    protected $dates = ['created_at'];
    protected $casts = [
      'stage_updated_at' => 'datetime',
      'delivered_at' => 'datetime',
    ];

    protected static $recordableEvents = ['created','updated','deleted','restored'];

    /**
 * Return the sluggable configuration array for this model.
 *
 * @return array
 */
    public static $status = "cold";

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function path()
    {
        return "/api/v1/projects/{$this->slug}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::forceDeleted(function ($project) {
            $project->activities()->delete();
        });
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function addTask($tasks)
    {
        return $this->tasks()->create([
          'title' => $tasks,
          'user_id' => auth()->id(),
          'status_id' => 1,
        ]);
    }

    public function addTasks($tasks)
    {
        //$this->timestamps = false;

        return $this->tasks()->createManyQuietly($tasks);
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members(): BelongsToMany 
    {
        return $this->belongsToMany(User::class, 'project_members')
                    ->withPivot('active')->withTimestamps();
    }

    public function activeMembers()
    {
        return $this
              ->members()
              ->wherePivot('active', true);
    }

    public function asignees()
    {
        return $this
        ->belongsToMany(User::class, 'project_members')
        ->wherePivot('active', true)
        ->select(['users.id', 'users.name', 'users.email']);
    }


    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function tasksReachedItsLimit()
    {
        $this->loadCount('tasks');
        return $this->tasks_count == config('app.project.taskLimit');
    }

    public function score()
    {
        //$this->loadCount(['tasks', 'activeMembers']);
        $scoreAction = new ScoreAction($this);
        $total = $scoreAction->calculateTotal();
        $this->updateStatus($total);
        return $total;
    }

    public function updateStatus($total)
    {
        if ($total >= ScoreValue::Hot_Score) {
            static::$status = "hot";
        }
    }

    public function getStatusAttribute()
    {
        return static::$status;
    }

    public function scopePastAbandonedLimit($query)
    {
        $abandonedLimit = config('app.project.abandonedLimit');

        $query->where('deleted_at', '<', Carbon::now()
               ->subDays($abandonedLimit));
    }

    public function scheduledMessages()
    {
        return $this
        ->messages()
        ->where('delivered', false)
        ->whereNotNull('delivered_at')
        ->whereDate('delivered_at', '>', Carbon::now())
        ->with('users:name')
        ->get();
    }

    public function limitedActivities()
    {
        return $this->activities()->take(5);
    }

    public function state()
    {
        return $this->deleted_at ? 'trashed' : 'active';
    }

    public function getStateAttribute()
    {
        return $this->deleted_at ? 'trashed' : 'active';
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

}
