<?php
namespace App\Services\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\FileType;
use App\Models\Conversation;
use App\Events\NewMessage;
use App\Services\Api\V1\FileService;
use App\Notifications\UserMentioned;
use App\Http\Requests\Api\V1\ConversationRequest;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class ConversationService 
{
    private FileService $fileService;

    /**
    * Service For File Storage 
    *
    * App\Service\Api\V1\FileService
    */
  public function __construct(FileService $fileService)
  {
    $this->fileService=$fileService;
  }

  /**
 * Stores a new conversation and dispatches events and notifications.
 */
  public function storeConversation(ConversationRequest $request,Project $project)
  {
    try{
    $data = $this->prepareConversationData($request, $project);

    $conversation = $this->createConversation($project, $data);

    $conversation->load('user'); 
     
     // Fire the NewMessage event
     //NewMessage::dispatch($conversation,$project->slug);

     $this->userMentioned($conversation,$project);

    return $conversation;
   }catch(\Exception $e){
     Log::error('Error storing conversation: ' . $e->getMessage());
   }
  }

  /**
 * Prepares the data required to create a conversation.
 */    
  private function prepareConversationData(ConversationRequest $request, Project $project): array
  {
    $data=[];

    if ($request->has('message')){
          $data = $request->safe()->only(['message']);
    }

    // Check if a file is present in the request and process the upload
    if ($request->has('file')) {
        $data['file'] = $this->fileService->store($project->id, 'file', FileType::CONVERSATION);
    }

    return $data;
  }

  private function createConversation(Project $project, array $data): Conversation
  {
    return $project->conversations()->create(array_merge($data, [
        'user_id' => auth()->id(),
    ]));
  }

  public function userMentioned(Conversation $conversation,Project $project): void
  {
    if (!$conversation->message) return;

    $mentionedUsers = $conversation->mentionedUsersData();

    if ($mentionedUsers->isEmpty()) return;
    
    try {
    Notification::send($mentionedUsers, new UserMentioned(auth()->user(),$project));
    }catch(\Exception $e){
        Log::error('Failed to send notifications', [
                    'error' => $e->getMessage(),
                    'users' => $users->pluck('id')->toArray(),
        ]);
    }
    
  }
}

?>