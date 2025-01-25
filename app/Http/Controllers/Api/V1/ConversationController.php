<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Events\DeleteConversation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\ConversationRequest;
use App\Services\Api\V1\ConversationService;

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

    /**
     * Store project group conversation.
     *
     */
    public function store(Project $project,
                          ConversationRequest $request): JsonResponse
    {
      $this->authorize('access',$project);
      
      $this->conversationService->storeConversation($request,$project);

       return response()->json([
        'message'=>'New conversation added to. '.$project->name,
        'path'=>$project->path()
      ],200);
    }

    public function destroy(Project $project,Conversation $conversation)
    {
      if(auth()->id() !== $conversation->user->id){
        return $this->respondForbidden("Not allowed to perform action");
      }

      DeleteConversation::dispatch($conversation,$project);

      if($conversation->has('file'){
         Storage::disk('s3')->delete($conversation->file);
      })

      $conversation->delete();

      return response()->json([
        'message'=>'Project Conversation deleted successfully',
        'path'=>$project->path()
      ],204);

    }
}
