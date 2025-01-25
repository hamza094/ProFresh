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

  public function storeConversation(ConversationRequest $request,Project $project): void
  {
    $data = $this->prepareConversationData($request, $project);

    $conversation = $this->createConversation($project, $data);
     
     // Fire the NewMessage event
     NewMessage::dispatch($conversation,$project->id);

     //Send Notification if user mentioned
     $this->userMentioned($conversation,$project);
  }

  /**
 * Prepares the data required to create a conversation.
 */    
  private function prepareConversationData(ConversationRequest $request, Project $project): array
  {
    $data = $request->safe()->only(['message']);

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

    $mentionedUsers = $conversation->mentionedUsers();

    if (empty($mentionedUsers) || !$conversation->message) {
        return;
    }

    $mentionedUsers = User::whereIn('username', $mentionedUsers)
        ->where('id', '<>', auth()->id())
        ->get();

    Notification::send($mentionedUsers, new UserMentioned(auth()->user(),$project));
  }
}

?>