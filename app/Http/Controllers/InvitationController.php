<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Searchable\Search;
use App\Project;
use App\Services\InvitationService;
use Auth;

class InvitationController extends Controller
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
  public function search(Request $request)
  {
    $results = $this->invitationService->memberSearch();

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
     $user=User::whereEmail(request('email'))->first();

     $this->invitationService->sendInvitation($user,$project);
   }

    /**
     * Accept project invitation.
     *
     * @param  int  $project
     */
  public function accept(Project $project)
  {
    $this->invitationService->acceptInvitation($project); 
  }

   /**
     * Cancel project invitation request.
     *
     * @param  int  $project
     */
  public function ignore(Project $project)
  {
    $project->members()->detach(Auth::user());     
  }
  
    /**
     * Cancel project invitation request by project owner.
     *
     * @param  int  $project
     */
  public function cancel(Project $project,User $user)
  {
    $this->invitationService->cancelInvitation($user,$project); 
  }

}
