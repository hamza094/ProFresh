<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redis;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Laravel\Paddle\Billable;
use App\Enums\OAuthProvider;
use Laravel\Sanctum\HasApiTokens;
use App\Jobs\QueuedVerifyEmailJob;
use App\Jobs\QueuedPasswordResetJob;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable implements Searchable, MustVerifyEmail
{
    use HasFactory, Notifiable, Billable, HasApiTokens,HasUuids;
    
    protected $guarded = [];

    //protected $appends = ['LastSeen'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

      /*protected static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {
            $user->projects->each->forceDelete();

        });
    }*/


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'oauth_token',
        'oauth_refresh_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'oauth_provider' => OAuthProvider::class,
        'oauth_token' => 'encrypted',
        'oauth_refresh_token' => 'encrypted',
    ];

    public function sendEmailVerificationNotification()
   {
       //dispactches the job to the queue passing it this User object
        QueuedVerifyEmailJob::dispatch($this);
   }

   public function sendPasswordResetNotification($token)
   {
       //dispactches the job to the queue passing it this User object
       QueuedPasswordResetJob::dispatch($this,$token);
   }

    public function path()
    {
        return "/api/v1/users/{$this->id}";
    }

    public function projects()
    {
       return $this->hasMany(Project::class);
    }

    /*public function lastseen() {
           $redis = Redis::connection();
           return $redis->get('last_active_' . $this->id);
    }*/

    public function conversations()
    {
      return $this->hasMany(Conversation::class);
    }

    public function info()
    {
       return $this->hasOne(UserInfo::class);
    }

    public function getSearchResult(): SearchResult
    {
       $url=$this->email;
      return new SearchResult($this, $this->name, $url);
    }

   public function members($active = false)
   {
    return $this->belongsToMany(Project::class, 'project_members')
        ->withTimestamps()
        ->wherePivot('active', $active)
        ->withTimestamps();
    }

    /*public function getlastSeenAttribute()
    {
      return  $this->lastseen();
    }*/

    public function getAvatarAttribute()
    {
        return $this->avatar_path ?: false;
    }

    public function messages()
    {
      return $this->belongsToMany(Message::class);
    }

    public function isSubscribed()
    {
      return $this->subscribed('monthly') || 
             $this->subscribed('yearly');
    }

    public function subscribedPlan()
    {
      return collect(['monthly', 'yearly'])
        ->first(function ($plan) {
            return $this->subscribed($plan);
        }, '');
    }

    public function hasGracePeriod()
    {
     return
      (
        $this->subscribed('monthly')
         && $this->subscription('monthly')->onGracePeriod())
        ||
        ($this->subscribed('yearly') && $this->subscription('yearly')->onGracePeriod());
    }
}
