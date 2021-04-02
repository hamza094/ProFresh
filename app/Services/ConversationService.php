<?php
namespace App\Services;
use App\Project;
use App\Conversation;
use Illuminate\Http\Request;
use App\User;

class ConversationService extends \App\Http\Controllers\Controller
{
    /**
     *  Store file conversation.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
  public function storeFileConversation($project,$request)
  {
    $this->validate($request, [
            'file'=>'required'
        ]);

    $value = $this->storeFile($request,'file',auth()->id());

    return $this->createConversation($project,'file',$value);
  }
 
    /**
     *  Store static conversation.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Response
     */
  public function storeStaticConversation($project,$request)
  {
    $this->validate($request, [
      'message'=>'required'
    ]);

   return $this->createConversation($project,'message',request('message'));
  }

    /**
     *  Create conversation.
     *
     * @param  int  $project,string $value
     * @return \Illuminate\Http\Response
     */
  public function createConversation($project,$name,$value)
  {
    return $conversation = Conversation::create([
      $name => $value,
      'group_id' => $project->group->id,
      'user_id' => auth()->id(),
      ]);
  }
}

?>