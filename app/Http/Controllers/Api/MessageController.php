<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use App\Services\MessageService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
  use ApiResponseHelpers;

  public function message(Project $project,MessageRequest $request,MessageService $message)
  {
     $message->checkOptionSelect($request);

     $users = collect($request->users)->filter(function($user) {
    return !empty($user['user_id']);
      })->pluck('user_id');

       return $message->send($project,$users);
  }

  public function scheduled(Project $project){

    if($project->scheduledMessages()->isEmpty()){

      return $this->respondNoContent([
        'message'=>'No project schedule messages found'
      ]);

    }
      return $project->scheduledMessages();
  }

  public function delete(Project $project,Message $message){

      $message->activities()->delete();

      $message->delete();

     return $this->respondNoContent([
       'message'=>'Scheduled message deleted Successfully'
     ]);

  }

}
