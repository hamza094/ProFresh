<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\BelongsToUser;

class Conversation extends Model
{
    use HasFactory;//,BelongsToUser;

	protected $guarded=[];

    protected $with=['user'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user(){
       return $this->belongsTo(User::class);
   }

    public function mentionedUsers()
    {
      preg_match_all('/@([\w\-]+)/', $this->message, $matches);

      return $matches[1];
    }

    public function setMessageAttribute($message)
    {
      $this->attributes['message'] = preg_replace(
            '/@([\w\-]+)/',
             '<a href="/user/$1/profile" target="_blank">$0</a>',
            $message
      );
    }
}


