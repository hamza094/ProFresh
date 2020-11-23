<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded=[];

    protected $touches=['lead'];

  protected $casts=['completed'=>'boolean'];

  public function path()
    {
        return "/api/leads/{$this->lead->id}/tasks/{$this->id}";
    }

    public function lead(){
      return $this->belongsTo(Lead::class,'lead_id');
    }

    public function Leadpath()
    {
        return "/leads/{$this->lead->id}/tasks/{$this->id}";
    }

    public function complete(){
      $this->update(['completed'=>true]);
   }

   public function incomplete(){
      $this->update(['completed'=>false]);
  }

}
