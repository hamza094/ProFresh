<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Events\DeleteConversation;
use App\Models\Project;
use App\Models\User;
use App\Models\Conversation;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ConversationRequest;
use App\Services\ConversationService;

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
      
      if($request->has('file'))
      {
        $conversation=$conversationService->     storeFileConversation($project,$request);
 
      }else{
        $conversation=$conversationService->storeStaticConversation($project,$request);
      }    

       NewMessage::dispatch($conversation,$project);

       $conversationService->userMentioned($conversation,$project);

       return $this->respondWithSuccess(['message'=>'New conversation added to. '.$project->name]);
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
