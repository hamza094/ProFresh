<?php
namespace App\Traits;
use App\Models\Project;

trait BelongsToProject
{
   public function project(){
       return $this->belongsTo(Project::class);
   }
}
