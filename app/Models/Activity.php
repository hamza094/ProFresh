<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
  use HasFactory;

  protected $guarded=[];

  protected $casts = [
    'changes' => 'array',
    'affected_users' => 'array'
  ];


  /**
   * Get the subject associated with the activity.
   *
   * @return MorphTo
   */
  public function subject(): MorphTo
  {
    return $this->morphTo();
  }


  /**
     * Get the user who created the activity.
     *
     * @return BelongsTo<User, Activity>
  */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }


  /**
    * Get the project associated with the activity.
    *
    * @return BelongsTo<Project, Activity>
  */
  public function project(): BelongsTo
  {
     return $this->belongsTo(Project::class);
  }

}
