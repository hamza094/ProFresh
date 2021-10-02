<?php
namespace App\Services;
use App\Models\Project;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Models\User;

class ConversationService extends \App\Http\Controllers\Api\ApiController
{

  public function storeFileConversation($project,$request)
  {
    $this->validate($request, [
            'file'=>'required'
        ]);

    $value = $this->storeFile($request,'file',auth()->id());

    return $this->createConversation($project,'file',$value);
  }
 
  public function storeStaticConversation($project,$request)
  {
    $this->validate($request, [
      'message'=>'required'
    ]);

   return $this->createConversation($project,'message',request('message'));
  }

  public function createConversation($project,$name,$value)
  {
    return $project->group->conversations()->create([
        $name => $value,
        'user_id' => auth()->id(),
      ]);
  }
}

?>