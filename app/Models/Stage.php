<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToProject;

class Stage extends Model
{
    use HasFactory,BelongsToProject;

    protected $guarded=[];
}
