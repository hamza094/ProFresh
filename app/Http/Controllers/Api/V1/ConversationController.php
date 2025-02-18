<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\ConversationRequest;
use App\Repository\Api\V1\ConversationRepository;
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

  public function index(Project $project,ConversationRepository $repository): JsonResponse 
  {
     $this->authorize('access',$project);
     
     $conversations = $repository->getProjectConversations($project);

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
