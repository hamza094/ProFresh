<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Conversation extends Model
{
    use HasFactory,BelongsToUser;

	 protected $guarded=[];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
