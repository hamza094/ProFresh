<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\RolesResource;

class UsersResource extends JsonResource
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
            'username'=>$this->username,
            'email'=>$this->email,
            'avatar'=>$this->avatar,
            'isSubscribed' => $this->isSubscribed() ? 'Subscribed' : 'Not Subscribed',
            'created_at'=>$this->created_at->diffForHumans(),
            'projects_count'=>$this->whenCounted('projects'),
            'projects_member'=>$this->members(true)->count(),
            'last_active'=>$this->when(!empty($this->last_active_at),
               fn()=>$this->last_active_at->diffForHumans()),
            'roles'=>RolesResource::collection($this->whenLoaded('roles')),
            'timezone'=>$this->timezone,
        ];
    }
}
