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
            $message
      );
    }

    public function mentionedUsersData(): Collection 
    {
        return empty($this->mentionedUsers()) 
        ? collect() 
        : User::whereIn('username', $this->mentionedUsers())
            ->select('uuid','name', 'username')
            ->get();
    }

}


