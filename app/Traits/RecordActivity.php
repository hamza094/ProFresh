<?php

namespace App\Traits;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Arr;
use App\Events\ActivityLogged;

trait RecordActivity
{
    /**
     * The project's old attributes.
     *
     * @var array
     */
    public $oldAttributes = [];
    /**
     * Boot the trait.
     */
    public static function bootRecordActivity()
    {
        foreach (self::recordableEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event),'');
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
     * @param  string $description
     * @return string
     */
    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }
    /**
     * Fetch the model events that should trigger activity.
     *
     * @return array
     */
    protected static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
        return ['created','updated','deleted'];
    }
    /**
     * Record activity for a project.
     *
     * @param string $description
     */
    public function recordActivity($description,$info)
    {
      $changes=$this->activityChanges();

      if($changes){
          if((Arr::exists($changes['before'], 'stage_updated_at'))){
            return 'Already exist';
          }
      }

      $activity=$this->activities()->create([
            'user_id' => auth()->id() ?: ($this->project ?? $this)->user->id,
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'info'=>$info,
        ]);

        ActivityLogged::dispatch($activity);
    }
    /**
     * The activity feed for the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activities($limit = true)
    {
     if (get_class($this) === Project::class) {
        $query = $this->hasMany(Activity::class)->with('user:id,name','subject')->latest();
    } else {
        $query = $this->morphMany(Activity::class, 'subject')->latest();
    }

    if ($limit) {
        $query->limit(5);
    }

    return $query->get();
}
    /**
     * Fetch the changes to the model.
     *
     * @return array|null
     */
      protected function activityChanges()
    {
        if ($this->wasChanged()) {
            return [
                'before' => array_except(
                    array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'
                ),
                'after' => array_except(
                    $this->getChanges(), 'updated_at'
                )
            ];
        }
    }
}
