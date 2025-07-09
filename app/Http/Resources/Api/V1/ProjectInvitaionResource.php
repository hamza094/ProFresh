<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\UsersResource;
use Illuminate\Http\Request;

/**
 * @mixin \App\Models\Project
 */
class ProjectInvitaionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * Project ID
             * @example 1
             */
            'id' => $this->id,

            /**
             * Project name
             * @example "My Project"
             */
            'name' => $this->name,

            /**
             * Invitation status (e.g. pending, accepted, rejected)
             * @example "pending"
             */
            'status' => $this->status,

            /**
             * Project slug
             * @example "my-project"
             */
            'slug' => $this->slug,

            /**
             * Date/time when the invitation was sent (formatted)
             * @example "2025-07-09 14:00:00"
             */
            'invitation_sent_at' => $this->pivot->created_at->format(config('app.date_formats.exact')),

            /**
             * Project owner details
             * @example {"uuid":176890,"name":"Owner Name",...}
             */
            'owner' => new UsersResource($this->whenLoaded('user')),

            /**
             * Project creation date (human readable)
             * @example "2 days ago"
             */
            'created_at' => $this->created_at->diffforHumans(),

            /**
             * Project API path
             * @example "/api/v1/my-project"
             */
            'path' => $this->path(),
        ];
    }
}
