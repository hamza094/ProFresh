<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Events\NewMessage;
use App\Models\Project;
use App\Services\ConversationService;


class ConversationController extends ApiController
{
    /**
     * Realtime project group conversation.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
    public function store(Project $project,Request $request)
    {
      $conversationService = new ConversationService();

      if(request()->has('file')){

      $conversation=$conversationService->storeFileConversation($project,$request);

    }else{

        $conversation=$conversationService->storeStaticConversation($project,$request);
    }
        broadcast(new NewMessage($conversation))->toOthers();

        return $conversation->load('user');
    }

    public function conversation(Project $project)
    {
      return $project->group->conversations->load('user');
    }
}
