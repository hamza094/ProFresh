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
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use App\Jobs\QueuedVerifyEmailJob;
use App\Jobs\QueuedPasswordResetJob;
use App\Traits\HasUuid;

class User extends Authenticatable implements Searchable, MustVerifyEmail
{
    use HasFactory, Notifiable, Billable, HasApiTokens, HasUuid;

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
            $user->groups->each->delete();
            $user->projects->each->forceDelete();

        });
    }*/


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
        return "/users/{$this->id}/profile";
    }

    public function projects()
    {
       return $this->hasMany(Project::class);
    }

    /*public function lastseen() {
           $redis = Redis::connection();
           return $redis->get('last_active_' . $this->id);
    }*/

    public function phone()
    {
       return $this->hasOne(UserInfo::class);
    }

    public function getSearchResult(): SearchResult
    {
       $url=$this->email;
      return new SearchResult($this, $this->name, $url);
    }

    public function affiliateProjects()
    {
        return $this->belongsToMany(Project::class,'project_members')->withPivot('active')->withTimestamps();
    }

     public function groups()
     {
        return $this->belongsToMany(Group::class)->withTimestamps();
     }

    /*public function getlastSeenAttribute()
    {
      return  $this->lastseen();
    }*/

    public function paypal()
    {
        return $this->belongsTo('App\Paypal');
    }

     //add user paypal record in database
    public function paypal_info()
    {
       $this->paypal()->create([
       'user_id'=>$this->id,
       'name'=>'ProFresh Agreement'
    ]);
    }

    public function messages()
    {
      return $this->belongsToMany(Message::class);
    }
}
