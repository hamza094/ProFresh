<?php
namespace App\Services;
use App\Models\Project;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\FileService;
 

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
}

?>