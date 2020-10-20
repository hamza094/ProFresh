<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\LeadScore;

class Lead extends Model
{
   protected $guarded=[];

    public function path()
    {
        return "/api/leads/{$this->id}";
    }

    protected $appends = ['profile'];

    //User avatar path
    public function getProfileAttribute()
    {
        if ($this->avatar_path != null) {
            $path = pathinfo($this->avatar_path);

            return $path['dirname'].'/'.$path['filename'].'-thumb.jpg';
        } else {
            $path = 'https://i.pinimg.com/originals/53/54/f7/5354f750a2816333f42efbeeacb4e244.jpg';

            return $path;
        }
    }

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
}


