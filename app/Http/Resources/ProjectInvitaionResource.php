<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MembersResource;

class ProjectInvitaionResource extends JsonResource
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
        'name'=>$this->name,
        'status'=>$this->status,
        'invitation_sent_at'=>$this->pivot->created_at->format(config('app.date_formats.exact')),
        'user'=>new MembersResource($this->whenLoaded('user')),
        'created_at'=>$this->created_at->diffforHumans(),
        'path'=>$this->path(),
        ];
    }
}
