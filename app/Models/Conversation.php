<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Conversation extends Model
{
    use HasFactory;

	protected $guarded=[];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
       return $this->belongsTo(User::class);
    }

    /** @var array<int, string> $mentionedUsers */
    public function mentionedUsers(): array
    {
     preg_match_all('/@([a-zA-Z][\w.-]*)/', $this->message ?? '', $matches);

     return array_unique($matches[1] ?? []);
    }

    public function mentionedUsersData(): Collection 
    {
        return empty($this->mentionedUsers()) 
        ? collect() 
        : User::whereIn('username', $this->mentionedUsers())
            ->select('id', 'name', 'username')
            ->get();
    }

}


