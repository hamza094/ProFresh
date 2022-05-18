<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ScoreResource;

class ProjectsResource extends JsonResource
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
        'slug'=>$this->slug,
        'stage'=>new StageResource($this->stage),
        'score'=>ScoreResource::collection($this->whenLoaded('scores'))->sum('point'),
        'created_at'=>$this->created_at->diffforHumans(),
        'completed'=>$this->completed,
        'links'=>[
          'self'=>"/api/v1/".$this->slug,
        ],
      ];
    }
}
