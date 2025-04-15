<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\InvitedUserResource;

class NotificationResource extends JsonResource
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
          'type' => class_basename($this->type),
          'message' => $this->data['message'],
          'link' => $this->data['link'],
          'notifier'=>new InvitedUserResource((object) ($this->data['notifier'] ?? [])),
          'read_at' => $this->read_at,
          'created_at'=>$this->created_at->diffForHumans(),
        ];
    }
}
