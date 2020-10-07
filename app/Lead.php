<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
   protected $guarded=[];

    public function path()
    {
        return "/api/leads/{$this->id}";
    }
}


