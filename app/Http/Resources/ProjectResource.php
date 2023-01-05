<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\ConversationResource;
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
          'user'=>$this->user()->select('id','name','avatar_path','username')->get(),
          'members'=>$this->activeMembersData(),
          'completed'=>$this->completed,
          'score'=>$this->score(),
          'tasks'=>$this->when($this->tasks()->exists(),
          fn()=>TaskResource::collection($this->whenLoaded('tasks'))->paginate(3)),

          'conversations'=>ConversationResource::collection($this->conversations)->take(50),

          'created_at'=>$this->created_at->diffforHumans(),
          'updated_at'=>$this->updated_at->diffforHumans(),

          'deleted_at'=>$this->when($this->deleted_at != null,
          fn()=>$this->deleted_at->diffforHumans()),
          'stage_updated_at'=>$this->stage_updated_at->format("F j, Y, g:i a"),
          'days_limit'=>config('project.abandonedLimit'),
          'activities'=>ActivityResource::collection($this->activities)->take(5),
        ];
    }
}
