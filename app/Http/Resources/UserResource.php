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
           'name'=>$this->name,
           'email'=>$this->email,
           'projects'=>ProjectResource::collection($this->whenLoaded('projects')),
           'created'=>$this->created_at->diffforHumans(),
           'updated'=>$this->updated_at->diffforHumans(),
        ];
    }
}
