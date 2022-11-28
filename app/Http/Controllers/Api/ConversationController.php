<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Models\Project;
use App\Http\Requests\ConversationRequest;
use App\Services\ConversationService;

class ConversationController extends ApiController
{
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

      if($request->has('file')){

      $conversation=$conversationService->storeFileConversation($project,$request);

    }else{
      $conversation=$conversationService->storeStaticConversation($project,$request);
    }    

      NewMessage::dispatch($conversation);
    }
}
