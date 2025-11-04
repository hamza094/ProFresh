<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stage extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the projects releated to the stage.
     *
     * @return HasMany<Project>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the project associated to the stage.
     *
     * @return BelongsTo<Project, Stage>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who created the stage.
     *
     * @return BelongsTo<User, Stage>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
