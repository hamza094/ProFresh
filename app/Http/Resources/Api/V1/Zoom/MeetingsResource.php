<?php

namespace App\Http\Resources\Api\V1\Zoom;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MeetingsResource extends JsonResource
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
           'topic'=>$this->topic,
           'agenda'=>$this->agenda,
           'created_at'=>$this->created_at->diffForHumans(),
           'start_time'=>Carbon::parse($this->start_time)->diffForHumans(),
           'status'=>$this->status,
           'timezone'=>$this->timezone,
        ];
    }
}
