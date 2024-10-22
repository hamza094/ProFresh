<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectStageResource extends JsonResource
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
        'stage'=>$this->when($this->stage()->exists(),
        fn()=>new StageResource($this->stage)
        ),
        $this->mergeWhen($this->completed, [
          'completed' => $this->completed,
      ]),
      'postponed'=>$this->whenNotNull($this->postponed),
      'stage_updated_at'=>$this->stage_updated_at->format(config('app.date_formats.exact')),
      ];
    }
}
