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
  public function storeFileConversation($project,$request)
  {
    $fileService=new FileService;
    
    $file=$fileService->store($request,'file',auth()->id());

     return $project->conversations()->create([
        'file' => $file,
        'user_id' => auth()->id(),
      ]);
  }
 
  public function storeStaticConversation($project,$request)
  {
    return $project->conversations()->create([
        'message' => $request->message,
        'user_id' => auth()->id(),
      ]);
  }

  public function userMentioned($conversation,$project)
  {
    if($conversation->message !== null)
    {
      User::whereIn('username', $conversation->mentionedUsers
        ())->get()
           ->filter(function($user){
              return $user->id !== auth()->user()->id;})
           ->each(function ($user) use ($project) {
            $user->notify(new UserMentioned(auth()->user()->toArray(),$project));
      });
    }
  }
}

?>