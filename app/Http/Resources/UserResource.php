<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProjectResource;

class UserResource extends JsonResource
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
           'message'=>$this->message,
           'file'=>$this->file,
           'user'=>$this->user->
                   select('id','name','avatar')->get(),
           'created'=>$this->created_at->diffforHumans(),
           'updated'=>$this->updated_at->diffforHumans(),
        ];
    }
}
