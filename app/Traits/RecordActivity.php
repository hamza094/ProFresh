<?php

namespace App\Traits;

use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Arr;
use App\Events\ActivityLogged;
use App\Events\DashboardActivity;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordActivity
{
    /**
     * The project's old attributes.
     *
     * @var array<string, mixed>
    */
    private $oldAttributes = [];


    /**
     * Boot the trait to record activity.
    */
    public static function bootRecordActivity(): void
    {
        foreach (static::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event),null);
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * Get the description of the activity.
     *
     * @param string $event
     * @return string
    */
    protected function activityDescription(string $event): string
    {
       return "{$event}_" . strtolower(class_basename($this));
    }

    /**
     * Fetch the model events that should trigger activity.
     *
     * @return array<int, string>
    */
    protected static function recordableEvents(): array
    {
        return static::$recordableEvents ?? ['created', 'updated', 'deleted'];
    }
    
    /**
     * Record activity for a project.
     *
     * @param string $description
     * @param string|null $info
    */
    public function recordActivity(string $description, ?string $info = null): void
    {
      $changes=$this->activityChanges();
      
        if($changes && (Arr::exists($changes['before'], 'stage_updated_at'))){
            return;
          }
       
      /** @var Activity $activity */ 
      $activity=$this->activities()->create([
            'user_id' => $this->resolveUserId(),
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'info'=>$info,
        ]);

        $activity->load(['user','project','subject']);

       if (!preg_match('/_stage|_taskstatus/', $description)) {
           ActivityLogged::dispatch($activity,class_basename($this) === 'Project' ? $this->id : $this->project_id,);
        }
        //DashboardActivity::dispatch($activity);
    }

    /**
     * Resolve the user ID for the activity.
     *
     * @return int
    */
    private function resolveUserId(): int
    {
      return auth()->id() ?? ($this->project ?? $this)
          ->user->id;
    }

    /**
    * The activity feed for the project.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\MorphMany<Activity>
    */
    public function activities(): HasMany|MorphMany
    {
        $query = ($this instanceof Project)
        ? $this->hasMany(Activity::class)
        : $this->morphMany(Activity::class, 'subject');

        return $query
            ->where('is_hidden', false)
            ->with(['user:id,name','subject'])
            ->latest();
    }

    /**
    * Fetch the changes to the model.
    *
    * @return array|null
    */
    protected function activityChanges(): ?array
    {
     if (!$this->wasChanged()) {
         return null;
       }

        return [
                'before' => Arr::except(
                    array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'
                ),
                'after' => Arr::except(
                    $this->getChanges(), 'updated_at'
                )
            ];
    }
}
