<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\StageResource;
use App\Http\Resources\Admin\UsersResource;

class ProjectResource extends JsonResource
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
        'about'=>str_limit($this->about,50),
        'slug'=>$this->slug,
        'state'=>$this->state(),
        'stage'=>$this->whenLoaded('stage'),
        'created_at'=>$this->created_at->diffforHumans(),
        'owner'=>$this->whenLoaded('user'),
        'tasks_count'=>$this->whenCounted('tasks'),
        'members_count'=>$this->whenCounted('activeMembers'),
        'score'=>$this->score(),
        'status'=>$this->status,
        'completed'=>$this->completed,
        'links'=>[
          'self'=>"/api/v1/".$this->slug,
        ],
        ];
    }
}
