<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\V1\InvitedUserResource;

/**
 * @mixin \App\Models\Conversation
 */
class ConversationResource extends JsonResource
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
        'id'=>$this->id,

        'message'=>$this->whenNotNull($this->message),

        'file'=>$this->whenNotNull($this->file),

        'user'=>new InvitedUserResource($this->whenLoaded('user')),

        'created_at'=>$this->created_at
                ->diffForHumans(),
                
        'links'=>[
          'project_link'=>$this->project->path(),
        ]        
     ]; 
    }

    /*private function formatMentions(?string $message): ?string
  {
    if (!$message) {
        return null;
    }

    return preg_replace(
        '/@([a-zA-Z][\w.-]*)/', // Match usernames
        '<a href="/user/$1/profile" target="_blank">@$1</a>', // Replace with hyperlink
        e($message) // Escape HTML to prevent XSS
    );
  }*/
}
