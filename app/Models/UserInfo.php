<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $guarded=[];
    
    /**
    * @var array<string>
    */
    protected $touches = ['user'];

   /**
     * Get the user who associated to the userinfp.
     *
     * @return BelongsTo<User, User::info>
     */ 
   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class);
   }

}
