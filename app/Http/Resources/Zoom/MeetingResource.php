<?php

namespace App\Http\Resources\Zoom;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use App\Http\Resources\UsersResource;
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
           'meeting_id'=>$this->meeting_id,
           'topic'=> Str::headline($this->topic),
           'agenda'=>Str::ucfirst($this->agenda),
           'created_at'=>$this->created_at->diffForHumans([
               'parts' => 3,
               'join' =>", ",
           ]),
           'updated_at'=>$this->updated_at->diffForHumans(),
           'owner'=>new UsersResource($this->whenLoaded('user')),
           'start_time'=>Carbon::parse($this->start_time)->format('j F Y, H:i'),
           'duration'=>$this->duration,
           'start_url'=>$this->start_url,
           'join_url'=>$this->join_url,
           'password'=>$this->password,
           'status'=>Str::ucfirst($this->status),
           'timezone'=>$this->timezone,
        ];
    }
}
