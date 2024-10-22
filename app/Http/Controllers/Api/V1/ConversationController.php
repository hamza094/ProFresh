<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Events\DeleteConversation;
use App\Models\Project;
use App\Models\User;
use App\Models\Conversation;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\ConversationRequest;
use App\Services\Api\V1\ConversationService;

class ConversationController extends ApiController
{
    use ApiResponseHelpers;
    /**
     * Realtime project group conversation.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,
                          ConversationRequest $request)
    {
      $conversationService = new ConversationService();
      
      $conversation=$conversationService->storeConversation($request,$project);
          
       NewMessage::dispatch($conversation,$project);

       $conversationService->userMentioned($conversation,$project);

       return $this->respondWithSuccess([
        'message'=>'New conversation added to. '.$project->name,
        'path'=>$project->path()
      ]);
    }

    public function destroy(Project $project,Conversation $conversation)
    {
      if(auth()->id() !== $conversation->user->id){
        return $this->respondForbidden("Not allowed to perform action");
      }

      DeleteConversation::dispatch($conversation,$project);

      $conversation->delete();

      return $this->respondNoContent();
    }
}
