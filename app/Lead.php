<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeadScore;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Activity;
use Illuminate\Support\Facades\Redis;


class Lead extends Model
{
  use SoftDeletes;
  use RecordActivity;
   protected $guarded=[];
  protected $dates = ['created_at'];
    protected $appends = ['IsSubscribedTo'];


    public function path()
    {
        return "/api/leads/{$this->id}";
    }

    //protected $appends = ['profile'];

    //User avatar path
/*    public function getProfileAttribute()
    {
        if ($this->avatar_path != null) {
            $path = pathinfo($this->avatar_path);

            return $path['dirname'].'/'.$path['filename'].'-thumb.jpg';
        } else {
            $path = 'https://i.pinimg.com/originals/53/54/f7/5354f750a2816333f42efbeeacb4e244.jpg';

            return $path;
        }
    }*/

    public function scores(){
        return $this->hasMany(LeadScore::class);
    }

    public function addScore($message,$point){
        return LeadScore::create([
            'lead_id'=>$this->id,
            'message'=>$message,
            'point'=>$point
        ]);
    }

    public function owner()
 {
     return $this->belongsTo(User::class,'user_id');
 }

 public function user()
{
  return $this->belongsTo(User::class,'user_id');
}

    public function subscribers(){
      return $this->hasMany(Subscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
      return  $this->subscribers()
              ->where('user_id', auth()->id())
              ->exists();
    }

    public function subscribe($userId = null)
{
    $this->subscribers()->create([
        'user_id'=>$userId ?: auth()->id()
    ]);

    return $this;
}

public function unsubscribe($userId = null)
{
    $this->subscribers()->where('user_id', $userId ?: auth()->id())->delete();
}

public function stageupdate() {
       $redis = Redis::connection();
       return $redis->get('stage_update_' . $this->id);
}

public function account(){
  return $this->belongsTo(Account::class,'account_id');
}

}
