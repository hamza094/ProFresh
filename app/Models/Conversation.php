<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use App\Traits\BelongsToUser;

class Conversation extends Model
{
    use HasFactory;//,BelongsToUser;

	protected $guarded=[];

    protected $with=['user'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user(){
       return $this->belongsTo(User::class);
   }
}
