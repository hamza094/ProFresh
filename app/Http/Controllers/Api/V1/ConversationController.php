<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\ConversationRequest;
use App\Services\Api\V1\ConversationService;
use App\Http\Resources\Api\V1\ConversationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConversationController extends ApiController
{
    private ConversationService $conversationService;

    /**
    * Service For Conversation Feature
    *
    * App\Service\Api\V1\ConversationService
    */
  public function __construct(ConversationService $conversationService)
  {
    $this->conversationService=$conversationService;
  }

  public function index(Project $project): JsonResponse 
  {
     $this->authorize('access',$project);

      $conversations = [];

    // Using chunkById to process data in chunks of 100
    $project->conversations()
        ->with('user')
        ->orderBy('id') // Ensure we process conversations in order by ID
        ->chunkById(100, function ($chunk) use (&$conversations) {
            // Merge the chunk of conversations with the $conversations array
            foreach ($chunk as $conversation) {
                // Add each conversation as a formatted ConversationResource
                $conversations[] = new ConversationResource($conversation);
            }
        });

    // Return the collected conversations
    return response()->json([
        'data' => $conversations,
    ]);
  }

    /**
     * Store project group conversation.
     *
     */
    public function store(Project $project,
                          ConversationRequest $request): JsonResponse 
    {
      $this->authorize('access',$project);
      
      $conversation=$this->conversationService->storeConversation($request,$project);

      return response()->json([
      'message' => 'New Conversation added Successfully',
      'conversation'=>new ConversationResource($conversation),
      ], 201); 
    }

    public function destroy(Project $project,Conversation $conversation): JsonResponse 
    {
      $this->authorize('delete', $conversation);

      $this->conversationService->deleteConversation($conversation, $project);

      return response()->json([
        'message'=>'Project Conversation deleted successfully',
        'path'=>$project->path()
      ],204);
    }
}
