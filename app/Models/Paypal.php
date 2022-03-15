<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToUser;

class Paypal extends Model
{
	use HasFactory,BelongsToUser;

    protected $guarded=[];
}
