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
use Illuminate\Validation\ValidationException;

class InvitationController extends ApiController
{
  private InvitationService $invitationService;

  /**
    * Service For Invitation Feature
    *
    * App\Service\Api\V1\InvitationService
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
   public function invite(Project $project,InvitationUsersRequest $request): JsonResponse
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
 * Accept Project Invitation
 * 
 * This endpoint allows the invited user to accept an invitation and become a member of the project.
 * 
 * ### Validation:
 * - Additional checks include:
 *   - **Validation Error:** Throw an error if the invitation is already accepted by users.
 * 
 * ### Authorization:
 * - This action can only be performed by invited user.
 * 
 */
   public function accept(Project $project): JsonResponse
   {
      try{

      $this->invitationService->acceptInvitation($project);

       return response()->json([
      'message'=>"You have accepted Project invitation",
      'project'=>new ProjectsResource($project),
      'accepted_user'=>new InvitedUserResource(Auth::user()),
    ],200);

    }catch(\Exception $ex){
      return response()->json(['error' => 'An unexpected error occurred.'], 500);
    }
   }


  /**
 * Reject Project Invitation
 *
 * This endpoint allows an invited user to reject a project invitation.
 * 
 * ### Functionality:
 * - Removes the user's association with the project, effectively canceling the invitation.
 * 
 * ### Authorization:
 * - Ensures only the user who was invited can perform this action.
 */
   public function reject(Project $project): JsonResponse
   {
     $user = Auth::user();

      $project->members()->detach($user);

      return response()->json([
        'message'=>'You have rejected the project request to join',
        'project'=>new ProjectsResource($project),
        'user'=>new InvitedUserResource($user),
      ],200);
   }


  /**
 * Remove Project Member
 * 
 * This endpoint allows the project owner to remove a member from the project.
 * 
 * ### Validation:
 * - The user must be an **active member** of the project to be removed.
 * 
 * ### Authorization:
 * - Only the project owner is authorized to perform this action.
 * 
 */
   public function remove(Project $project,User $user): JsonResponse
   {
      try {
        $this->invitationService->removeMember($user, $project);

        return response()->json([
            'message' => "Member {$user->name} has been removed from the project",
            'user' => new InvitedUserResource($user),
        ], 200);
    } catch (ValidationException $ex) {
        return response()->json(['error' => $ex->getMessage()], 422);
    }
   }

}
