<?php

namespace App\Http\Resources\Api\V1\Zoom;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Meeting
 */
class MeetingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'topic' => $this->topic,
            'agenda' => $this->agenda,
            'created_at' => $this->created_at->diffForHumans(),
            'start_time' => Carbon::parse($this->start_time)->diffForHumans(),
            'status' => $this->status,
            'timezone' => $this->timezone,
        ];
    }
}
