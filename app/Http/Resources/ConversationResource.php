<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

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

        'message'=>$this->when(!empty($this->message),
                   fn()=>$this->message),

        'file'=>$this->when(!empty($this->file),
                  fn()=>$this->file),

        'user'=>new UserResource($this->whenLoaded('user')),

        'created_at'=>$this->created_at
                ->format(config('app.date_formats.exact')),
     ]; 
    }
}
