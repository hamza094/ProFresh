<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
        'id'=>$this->id,

        'message'=>$this->when($this->message != null,
                 fn()=>$this->message),

        'file'=>$this->when($this->file != null,
                  fn()=>$this->file),

        'user'=>$this->user()->select('name','id','avatar_path')->get(),

        'created_at'=>$this->created_at->format("F j, Y, g:i a"),
     ]; 
    }
}
