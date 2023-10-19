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
        'stage'=>new StageResource($this->stage),
        'created_at'=>$this->created_at->diffforHumans(),
        'owner'=>$this->user()->select('id','avatar_path','username','name')->first(),
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
