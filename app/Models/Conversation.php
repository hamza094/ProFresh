<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the project associated with the conversation.
     *
     * @return BelongsTo<Project, Conversation>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user who sent the conversation.
     *
     * @return BelongsTo<User, Conversation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setMessageAttribute($message)
    {
        $this->attributes['message'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/user/$1/profile" target="_blank">$0</a>',
            (string) $message
        );
    }

    public function mentionedUsers(): array
    {
        $message = (string) ($this->message ?? '');
        if ($message === '') {
            return [];
        }

        // Extract usernames preceded by a non-word boundary to avoid matching emails (name@domain)
        // Allows letters, numbers, underscore, dot and hyphen in usernames
        preg_match_all('/(?<![\w])@([\w.-]+)/', $message, $matches);
        $usernames = $matches[1] ?? [];

        // De-duplicate while preserving order
        $seen = [];
        $unique = [];
        foreach ($usernames as $name) {
            if (! isset($seen[$name])) {
                $seen[$name] = true;
                $unique[] = $name;
            }
        }

        return $unique;
    }

    public function mentionedUsersData(): Collection
    {
        return $this->mentionedUsers() === []
        ? collect()
        : User::whereIn('username', $this->mentionedUsers())
            ->select('id', 'uuid', 'name', 'username')
            ->get();
    }
}
