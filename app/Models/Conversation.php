<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

	protected $guarded=[];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user(){
       return $this->belongsTo(User::class);
   }

    public function mentionedUsers(): array
   {
    // Extract usernames from the message
    preg_match_all('/@([\w.\-]+)/', $this->message ?? '', $matches);

    // Find the UUIDs of mentioned users
       return $matches[1] ?? [];
   }

public function setMessageAttribute($message): void
{
    $this->attributes['message'] = preg_replace_callback(
        '/@([\w.\-]+)/',
        function ($matches) {
            $username = htmlspecialchars($matches[1], ENT_QUOTES, 'UTF-8');

            // Check if user exists and get their UUID
            $user = User::where('username', $username)->first();
            if ($user) {
                $url = route('user.profile', ['uuid' => $user->uuid]); // Dynamic URL with UUID
                return "<a href=\"$url\" target=\"_blank\">@{$username}</a>";
            }

            // Return plain mention if user doesn't exist
            return "@{$username}";
        },
        $message ?? ''
    );
}


}


