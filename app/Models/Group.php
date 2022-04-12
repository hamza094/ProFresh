<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToProject;

class Group extends Model
{
    use HasFactory,BelongsToProject;
    protected $guarded=[];

     public static function boot()
    {
        parent::boot();
        static::deleting(function ($group) {
            $group->conversations->each->delete();
        });
    }

    public function users(){
          return $this->belongsToMany(User::class)->withTimestamps();
      }

    public function conversations(){
        return $this->hasMany(Conversation::class);

    }

    public function hasUser($user_id)
   {
       foreach ($this->users as $user) {
           if($user->id == $user_id) {
               return true;
           }
       }

}
}
