<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redis;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements Searchable
{
    use Notifiable;

    protected $appends = ['LastSeen'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

      public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->groups->each->delete();
            $user->projects->each->forceDelete();

        });
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function path()
    {
        return "/users/{$this->id}/profile";
    }

      public function projects(){
        return $this->hasMany(Project::class);
      }

    public function lastseen() {
           $redis = Redis::connection();
           return $redis->get('last_active_' . $this->id);
    }

    public function appointments(){
      return $this->hasMany(Appointment::class);
    }

    public function getSearchResult(): SearchResult
   {
     $url=$this->email;
      return new SearchResult($this, $this->name,$url);
   }

   public function members()
    {
        return $this->belongsToMany(Project::class,'project_members')->withPivot('active')->withTimestamps()->with('owner');
    }

     public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function getlastSeenAttribute()
    {
      return  $this->lastseen();
    }

}
