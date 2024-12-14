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

  protected $casts = ['changes' => 'array'];

  public function subject(): MorphTo
  {
    return $this->morphTo();
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function project(): BelongsTo
  {
     return $this->belongsTo(Project::class);
  }

}
