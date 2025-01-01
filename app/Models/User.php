<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Laravel\Paddle\Billable;
use App\Enums\OAuthProvider;
use Laravel\Sanctum\HasApiTokens;
use App\Jobs\QueuedVerifyEmailJob;
use App\Jobs\QueuedPasswordResetJob;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Billable, HasApiTokens,HasRoles;
    
    protected $guarded = [];

    public function guardName(): string { return 'sanctum'; }

    public function getRouteKeyName(): string
   {
     return 'uuid';
   }


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
        'zoom_access_token',
        'zoom_refresh_token',
        'zoom_expires_at',
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
        'last_active_at'=>'datetime',
         'zoom_access_token' => 'encrypted',
         'zoom_refresh_token' => 'encrypted',
         'zoom_expires_at' => 'datetime',
    ];

     protected static function boot()
    {
        parent::boot();

        // Automatically create a UUID for 'user_id'
        static::creating(function ($user) {
            $user->uuid = (string) Str::uuid();
        });
    }

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
        return true;
      /*return $this->subscribed('monthly') || 
             $this->subscribed('yearly') || 
             $this->isAdmin();*/
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

    public function tasks()
    {
      return $this->hasMany(Task::class);
    }

    public function assigned()
    {
      return $this->belongsToMany(Task::class);
    }

    public function isAdmin()
    {
        return $this->hasRole('Admin');

    }

    public function updateZoomOAuthDetails(
        string $accessToken,
        string $refreshToken,
        \DateTimeImmutable $expiresAt
  ): void {
        $this->zoom_access_token = $accessToken;
        $this->zoom_refresh_token = $refreshToken;
        $this->zoom_expires_at = $expiresAt;
        $this->save();
  }

   public function isConnectedToZoom(): bool
   {
       return $this->zoom_access_token
       && $this->zoom_refresh_token
       && $this->zoom_expires_at;
    }

   public function meetings()
   {
      return $this->hasMany(Meeting::class); 
   } 

}
