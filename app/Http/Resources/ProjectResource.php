<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\UsersResource;
use Carbon\Carbon;

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
          'slug'=>$this->slug,
          'name'=>$this->name,
          'about'=>$this->about,
          'notes'=>$this->notes,
          'stage'=>new StageResource($this->stage),
          'postponed'=>$this->postponed,

          'user'=>$this->user()->select('id','name','avatar_path','username','email')->first(),
          
          'members'=>UsersResource::collection($this->activeMembers()->get()),

          'completed'=>$this->completed,
          'score'=>$this->score(),

          'conversations'=>ConversationResource::collection($this->whenLoaded('conversations')->take(25)),

          'created_at'=>$this->created_at->diffforHumans(),
          'updated_at'=>$this->updated_at->diffforHumans(),

          'deleted_at'=>$this->when(!empty($this->deleted_at),
                     fn()=>$this->deleted_at->diffforHumans()),

          'stage_updated_at'=>$this->stage_updated_at
                 ->format(config('app.date_formats.exact')),

          'days_limit'=>config('app.project.abandonedLimit'),

          'activities'=>ActivityResource::collection($this->getLimitedActivities()),
        ];
    }
}
