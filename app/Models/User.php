<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Paddle\Billable;
use App\Enums\OAuthProvider;
use Laravel\Sanctum\HasApiTokens;
use App\Jobs\QueuedVerifyEmailJob;
use App\Jobs\QueuedPasswordResetJob;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\HasSubscription;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Billable, HasApiTokens, HasRoles, HasSubscription, SoftDeletes;
    
    protected $guarded = [];

    public function guardName(): string 
    { 
        return 'sanctum'; 
    }

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

      protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->uuid = (string) Str::uuid();
        });
        
        static::deleting(function ($user) {
          $user->projects()->delete();
        });

        static::forceDeleting(function ($user) {
            $user->notifications()->delete();
        });
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
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
     * @var array<string, string>
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


    public function sendEmailVerificationNotification(): void
   {
       //dispactches the job to the queue passing it this User object
        QueuedVerifyEmailJob::dispatch($this);
   }

   public function sendPasswordResetNotification($token): void
   {
       //dispactches the job to the queue passing it this User object
       QueuedPasswordResetJob::dispatch($this,$token);
   }

    public function path(): string
    {
        return "/api/v1/users/{$this->uuid}";
    }

    /**
     * Get projects created by user.
     *
     * @return HasMany<Project>
     */ 
    public function projects(): HasMany
    {
       return $this->hasMany(Project::class);
    }

    /*public function lastseen() {
           $redis = Redis::connection();
           return $redis->get('last_active_' . $this->id);
    }*/

    
    /**
    * Get all conversation associated by user
    *
    * @return HasMany<Conversation>
    */
    public function conversations():HasMany
    {
      return $this->hasMany(Conversation::class);
    }

     /**
    * Get user profile information
    *
    * @return HasOne<UserInfo>
    */
    public function info(): HasOne
    {
       return $this->hasOne(UserInfo::class);
    }

    /**
     * Get projects which user is member of.
     *
     * @return BelongsToMany<Project>
     */
    public function members($active = false): BelongsToMany
    {
     return $this->belongsToMany(Project::class, 'project_members')
        ->wherePivot('active', $active)
        ->withTimestamps();
    }

    /*public function getlastSeenAttribute()
    {
      return  $this->lastseen();
    }*/

    public function getAvatarAttribute(): string|bool
    {
        return $this->avatar_path ?: false;
    }

    /**
    * Get all messages created by user
    *
    * @return belongsToMany<Message>
    */
    public function messages(): BelongsToMany
    {
      return $this->belongsToMany(Message::class);
    }

    /**
    * Get all tasks created by the user
    *
    * @return HasMany<Task>
    */
    public function tasks(): HasMany
    {
      return $this->hasMany(Task::class);
    }

    /**
    * Get tasks assigned to user
    *
    * @return BelongsToMany<Task>
    */
    public function assigned(): BelongsToMany
    {
      return $this->belongsToMany(Task::class);
    }

    public function isAdmin(): bool
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

     /**
     * Get meetings created by user.
     *
     * @return HasMany<Meeting>
     */ 
    public function meetings(): HasMany
    {
      return $this->hasMany(Meeting::class); 
    } 

    public function getNotifierData(): array
    {
    return [
        'uuid'         => $this->uuid,
        'name'         => $this->name,
        'username'     => $this->username,
        'avatar_path'  => $this->avatar_path,
    ];
    }

}
