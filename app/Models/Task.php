<?php

namespace App\Models;

//use App\Traits\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToProject;

class Task extends Model
{
  use HasFactory,BelongsToProject;

  protected $guarded=[];

  protected $touches=['project'];

  protected $casts=['completed'=>'boolean'];

  protected static $recordableEvents = ['created','updated','deleted'];

  public function path()
    {
        return "/api/v1/projects/{$this->project->slug}/task/{$this->id}";
    }

    public function activity()
    {
       return $this->morphMany(Activity::class,'subject')->latest();
    }

    public function complete()
    {
      $this->update(['completed'=>true]);
    }

    public function incomplete()
    {
      $this->update(['completed'=>false]);
    }

}
