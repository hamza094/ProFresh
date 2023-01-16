<?php
namespace App\Services;
use App\Models\Project;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\FileService;
use App\Notifications\UserMentioned;

class ConversationService 
{

  public function storeConversation($request,Project $project){

    return $request->has('file')  
    ? $this->storeFileConversation($project,$request)
    : $this->storeStaticConversation($project,$request);
  }
    
  private function storeFileConversation($project,$request)
  {
    $fileService=new FileService;
    
    $file=$fileService->store($request,'file',auth()->id());

     return $project->conversations()->create([
        'file' => $file,
        'user_id' => auth()->id(),
      ]);
  }
 
  private function storeStaticConversation($project,$request)
  {
    return $project->conversations()->create([
        'message' => $request->message,
        'user_id' => auth()->id(),
      ]);
  }

  public function userMentioned($conversation,$project): void
  {
     if($conversation->message === null) {
        return;
    }

    $mentionedUsers = User::whereIn('username', $conversation->mentionedUsers())
        ->where('id', '!=', auth()->user()->id)
        ->get();

    $mentionedUsers->each(fn($user) => $user->notify(new UserMentioned(auth()->user()->toArray(), $project)));
  }
}

?>