<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ScoreResource;
use App\Http\Resources\UserResource;

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
          'stage'=>$this->stage,
          'postponed'=>$this->postponed,
          'scores'=>$this->when($this->scores()->exists(),
          fn()=>ScoreResource::collection($this->whenLoaded('scores'))
          ),
          'score'=>ScoreResource::collection($this->whenLoaded('scores'))->sum('point'),
          'user'=>$this->user()->select('id','name')->get(),
          'created_at'=>$this->created_at->diffforHumans(),
          'updated_at'=>$this->updated_at->diffforHumans(),
        ];
    }
}