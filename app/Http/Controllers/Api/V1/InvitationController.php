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
use App\Http\Requests\Api\V1\InvitationUsersRequest;
use App\Http\Resources\Api\V1\Task\TaskMemberResource;
use App\Http\Resources\Api\V1\InvitedUserResource;
use Auth;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
  */
  public function search(Project $project,Request $request): AnonymousResourceCollection
  {
    $results = $this->invitationService->usersSearch($project,$request);

    return TaskMemberResource::collection($results);
   }

     /**
 * Send Project Invitation
 * 
 * This endpoint allows the project owner to send an invitation to a specific user to become a member of the project.
 * 
 * ### Validation:
 * - Additional checks include:
 *   - **Validation Error:** Throw an error if the invitation is sent to the project owner.
 *   - **Validation Error:** Throw an error if a project invitation has already been sent to the user.
 * 
 * ### Authorization:
 * - This action can only be performed by the project owner, enforced via policy checks.
 * 
 */

   public function store(Project $project,InvitationUsersRequest $request): JsonResponse
   {
      $user=User::whereEmail($request->validated())->first();

      try {
        $this->invitationService->sendInvitation($user, $project);

        return response()->json([
            'message' => "Project invitation sent to " . $user->name,
            'project' => new ProjectsResource($project),
            'invited_user'=>new InvitedUserResource($user),
        ], 200);

    } catch (ValidationException $ex) {
        return response()->json(['error' => $ex->getMessage()], 422);
    }
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
