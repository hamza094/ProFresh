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
     preg_match_all('/@([a-zA-Z][\w.-]*)/', $this->message ?? '', $matches);

     return array_unique($matches[1] ?? []);
    }

    public function mentionedUsersData()
    {
        return empty($this->mentionedUsers()) 
        ? collect() 
        : User::whereIn('username', $this->mentionedUsers())
            ->select('id', 'name', 'username')
            ->get();
    }

}


