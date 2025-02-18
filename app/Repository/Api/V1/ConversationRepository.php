<?php

namespace App\Repository\Api\V1;

use App\Models\Project;
use App\Http\Resources\Api\V1\ConversationResource;
use Illuminate\Support\Collection;

class ConversationRepository
{
    
    /**
     * Fetch all project conversations in an optimized manner.
     * Uses lazy loading to prevent memory overflow.
     *
     * @param Project $project
     * @return Collection<int, ConversationResource>
     */
    public function getProjectConversations(Project $project): Collection
    {
        
    return $project->conversations()
        ->with(['user','project:id,slug'])
        ->orderBy('id') 
        ->lazyById(100) // Memory efficient
            ->map(fn($conversation) => 
                 new ConversationResource($conversation))
            ->collect();
    }
}