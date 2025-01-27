<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Events\DeleteConversation;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\ConversationRequest;
use App\Services\Api\V1\ConversationService;
use App\Http\Resources\Api\V1\ConversationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ConversationController extends ApiController
{
    private ConversationService $conversationService;

    /**
    * Service For Conversation Feature
    *
    * App\Service\Api\V1\ConversationService
    */
  public function __construct(ConversationService $conversationService)
  {
    $this->conversationService=$conversationService;
  }

  public function index(Project $project)
  {
     $this->authorize('access',$project);

     $conversations=$project->conversations()
     ->with('user')
     ->latest()
     ->get();

     return ConversationResource::Collection($conversations)->paginate(10);
  }

    /**
     * Store project group conversation.
     *
     */
    public function store(Project $project,
                          ConversationRequest $request): JsonResponse 
    {
      $this->authorize('access',$project);
      
      $conversation=$this->conversationService->storeConversation($request,$project);

      $conversation->load('user');

      return response()->json([
      'message' => 'Conversation added Successfully',
      'conversation'=>new ConversationResource($conversation),
      ], 201); 
    }

    public function destroy(Project $project,Conversation $conversation)
    {
      if(auth()->id() !== $conversation->user->id){
        return $this->respondForbidden("Not allowed to perform action");
      }

      DeleteConversation::dispatch($conversation,$project);

      /*if($conversation->has('file'){
         Storage::disk('s3')->delete($conversation->file);
      })*/

      $conversation->delete();

      return response()->json([
        'message'=>'Project Conversation deleted successfully',
        'path'=>$project->path()
      ],204);

    }
}
