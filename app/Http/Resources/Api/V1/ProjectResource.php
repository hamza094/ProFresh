<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\ActivityResource;
use App\Http\Resources\Api\V1\ConversationResource;
use App\Http\Resources\Api\V1\UsersResource;
use App\Http\Resources\Api\V1\StageResource;
use Carbon\Carbon;

/**
 * @mixin \App\Models\Project
 */
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
        /**
         *  @example 1
        */
          'id'=>$this->id,

        /**
         * @example the-dimension
        */
          'slug'=>$this->slug,

        /**
         * @example The Dimension
        */
          'name'=>$this->name,

        /**
         *  @example it describes what the project is about.
        */
          'about'=>$this->about,

        /**
         *  @example This is project-specific note
        */
          'notes'=>$this->notes,

        /**
         * Indicates whether the project phase is completed.
         * Returns true if completed, otherwise false.
         * @example false
        */
          'completed'=>$this->completed,

        /**
         * The total score associated with the project.
         * @example 5
        */
          'score'=>$this->score(),

        /**
         * Reason why the project phase was postponed, if any.
         * @example null
        */
          'postponed'=>$this->postponed,

        /**
         * Date when the project was created, displayed in a human-readable format.
         * @example 4 June 2024
        */
          'created_at'=>$this->created_at->diffforHumans(),

        /**
         * Date when the project was last updated, displayed in a human-readable format.
         * @example 4 June 2024
         */
          'updated_at'=>$this->updated_at->diffforHumans(),

        /**
         * Shows the date the project was deleted if it is currently in the "trashed" state.
         * @example 10 June 2024
        */
          'deleted_at'=>$this->when(!empty($this->deleted_at),
                     fn()=>$this->deleted_at->diffforHumans()),

        /**
         * Date when the project's last stage was updated, formatted based on the application's date format configuration.
         * @example 10 June 2024
        */
        'stage_updated_at'=>$this->when(!empty($this->stage_updated_at),
               fn()=>$this->stage_updated_at
                 ->format(config('app.date_formats.exact'))),

          'ownerNotAuthorized' => auth()->user()->is($this->user) && !auth()->user()->isConnectedToZoom(),

          'days_limit'=>config('app.project.abandonedLimit'),

        /**
         * Basic details of the project owner.
         * @example [data]
        */
         'user'=>$this->user()->select('uuid','name','avatar_path','username','email')->first(),


        /**
         * Current stage information for the project.
        */
        'stage'=>new StageResource($this->stage),

        /**
         * List of active project members.
        */
        'members'=>UsersResource::collection($this->activeMembers()->get()),

        /**
         * Limited list of project chat conversations.
        */
        'conversations'=>ConversationResource::collection($this->whenLoaded('conversations')->take(25)),

        /**
         * Limited list of recent project activities.
        */
        'activities'=>ActivityResource::collection($this->getLimitedActivities()),
        ];
    }
}
