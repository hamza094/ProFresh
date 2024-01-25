<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserInfoResource;
use App\Http\Resources\ProjectInvitaionResource;
use App\Http\Resources\Admin\RolesResource;

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
        'id' => $this->id,
        'name' => $this->name,
        'username' => $this->username,
        'avatar' => $this->when($this->avatar,
                                fn()=>$this->avatar_path),
        'timezone' => $this->timezone,
        'email' => $this->email,

        'verified' => $this->when($this->id == auth()->id(), 
          fn()=> $this->email_verified_at->diffForHumans()),

        'info' => new UserInfoResource($this->info),

        'invited_projects' =>ProjectInvitaionResource::collection($this->whenLoaded('members')),

        'roles'=>RolesResource::collection($this->whenLoaded('roles')),

        'created_at'=>$this->created_at->diffForHumans(),
        'updated_at'=>$this->updated_at->diffForHumans()
        ];
    }
}
