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
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Redis;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\ScoreValue;
use Illuminate\Support\Collection;
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

    /**
     * Project model cast properties.
     *
     * @var array<string,string>
    */
    protected $casts = [
      'stage_updated_at' => 'datetime',
      'delivered_at' => 'datetime',
    ];
    
    /**
     * The events that should be recorded.
     *
     * @var array<string>
   */
    protected static $recordableEvents = ['created','updated','deleted','restored'];

    
    /**
    * @var string
    */
    public static $status = "cold";


    /**
 * Return the sluggable configuration array for this model.
 *
 * @return array
 */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function path(): string
    {
        return "/api/v1/projects/{$this->slug}";
    }
    
    /**
     * Get user associated to the project.
     *
     * @return BelongsTo<User, Project>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot(): void
    {
        parent::boot();
        static::forceDeleted(function ($project) {
            $project->activities()->delete();
        });
    }

    /**
     * Get stage associated to the project.
     *
     * @return BelongsTo<Stage, Project>
     */
    public function stage(): BelongsTo
    {
        return $this->belongsTo(Stage::class);
    }

    /**
     * Get tasks releated to the project.
     *
     * @return HasMany<Task>
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    /**
     * Get project messages.
     *
     * @return HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function addTask(string $title): Task
    {
        return $this->tasks()->create([
          'title' => $title,
          'user_id' => auth()->id(),
          'status_id' => 1,
        ]);
    }

    public function addTasks($tasks)
    {
        //$this->timestamps = false;

        return $this->tasks()->createManyQuietly($tasks);
    }

    public function invite(User $user): void
    {
        $this->members()->attach($user);
    }
    
    /**
     * Get the project members.
     *
     * @return BelongsToMany<User>
     */
    public function members(): BelongsToMany 
    {
        return $this->belongsToMany(User::class, 'project_members')
                    ->withPivot('active')->withTimestamps();
    }
    
    /**
     * Get project active members.
     *
     * @return BelongsToMany<User>
     */
    public function activeMembers(): BelongsToMany
    {
        return $this
              ->members()
              ->wherePivot('active', true);
    }

    /**
     * Get the project active members.
     *
     * @return BelongsToMany<User>
     */
    public function asignees(): BelongsToMany
    {
        return $this
        ->belongsToMany(User::class, 'project_members')
        ->wherePivot('active', true)
        ->select(['users.id', 'users.name', 'users.email']);
    }

   /**
     * Get chat conversations releated to the project.
     *
     * @return HasMany<Conversation>
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function tasksReachedItsLimit(): bool
    {
        $this->loadCount('tasks');
        return $this->tasks_count == config('app.project.taskLimit');
    }

    public function score(): int
    {
        //$this->loadCount(['tasks', 'activeMembers']);
        $scoreAction = new ScoreAction($this);
        $total = $scoreAction->calculateTotal();
        $this->updateStatus($total);
        return $total;
    }

    public function updateStatus(int $total): void
    {
        if ($total >= ScoreValue::Hot_Score) {
            static::$status = "hot";
        }
    }

    public function getStatusAttribute(): string
    {
        return static::$status;
    }

    public function scopePastAbandonedLimit(Builder $query)
    {
        $abandonedLimit = config('app.project.abandonedLimit');

        $query->where('deleted_at', '<', Carbon::now()
               ->subDays($abandonedLimit));
    }

    /**
     * Get all scheduled messages releated to project
     * 
     * @return Collection<int, Message>
     */ 
    public function scheduledMessages(): Collection
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

    public function state(): string
    {
        return $this->deleted_at ? 'trashed' : 'active';
    }

    public function getStateAttribute(): string
    {
        return $this->deleted_at ? 'trashed' : 'active';
    }
    
    /**
     * Get meetings releated to the project.
     *
     * @return HasMany<Meeting>
     */ 
    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }

}
