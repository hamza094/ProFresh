<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\UsersResource;

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

        'message'=>$this->whenNotNull($this->message),

        'file'=>$this->whenNotNull($this->file),

        'user'=>new UsersResource($this->whenLoaded('user')),

        'created_at'=>$this->created_at
                ->format(config('app.date_formats.exact')),
     ]; 
    }
}
