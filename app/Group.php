<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded=[];

    public function users(){
          return $this->belongsToMany(User::class)->withTimestamps();
      }

    public function project(){
      return $this->belongsTo(Project::class,'project_id');
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
