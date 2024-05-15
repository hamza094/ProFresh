<?php

namespace App\Http\Resources\Zoom;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MeetingResource extends JsonResource
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
           'created_at'=>$this->created_at,
           'start_time'=>Carbon::parse($this->start_time)->diffForHumans(),
           'status'=>$this->status,
           'timezone'=>$this->timezone,
        ];
    }
}
