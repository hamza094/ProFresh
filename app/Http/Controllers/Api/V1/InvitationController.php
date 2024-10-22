<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Searchable\Search;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use App\Services\Api\V1\InvitationService;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\ProjectsResource;
use Auth;

class InvitationController extends ApiController
{
  private $invitationService;

  /**
    * Service For Invitation Feature
    *
    * App\Service\InvitationService
    */
  public function __construct(InvitationService $invitationService)
  {
    $this->invitationService=$invitationService;
  }

  /**
     * Search Users to send project invitation.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Request
     */
  public function search(Request $request): JsonResponse
  {
    $results = $this->invitationService->memberSearch($request);

    return response()->json($results);
   }

     /**
     * Send project invitation.
     *
     * @param  int  $project
     * @return \Illuminate\Http\Request
     */
   public function store(Project $project,Request $request)
   {
      $user=User::whereEmail($request->email)->first();

      return $this->invitationService->sendInvitation($user,$project);
   }

    /**
     * Accept project invitation.
     *
     * @param  int  $project
     */
   public function accept(Project $project)
   {
      $this->authorize('owner', auth()->user());

     return $this->invitationService->acceptInvitation($project);
   }

   /**
     * Cancel project invitation request.
     *
     * @param  int  $project
     */
   public function ignore(Project $project): JsonResponse
   {
     $user = Auth::user();

      $this->authorize('owner', $user);

      $project->members()->detach($user);

      return response()->json([
        'message'=>'You have rejected the project request to join',
        'project'=>new ProjectsResource($project)
      ]);
   }

    /**
     * Cancel project invitation request by project owner.
     *
     * @param  int  $project
     */
   public function remove(Project $project,User $user)
   {
     return $this->invitationService
                 ->removeMember($user,$project);
   }

}
