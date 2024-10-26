<?php

namespace App\Http\Controllers\Api\V1;

use Auth;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\ProjectRequest;
use App\Http\Requests\Api\V1\ProjectStoreRequest;
use App\Services\Api\V1\ProjectService;
use App\Repository\ProjectRepository;
use App\Http\Resources\Api\V1\ProjectResource;
use App\Http\Resources\Api\V1\ProjectsResource;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\DB;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
  use ApiResponseHelpers;

  public function store(ProjectStoreRequest $request,ProjectService $service): JsonResponse
  {
    DB::beginTransaction();

    try{

    $project = Auth::user()->projects()
                  ->create($request->validated());
         
    $service->addTasksToProject($project,$request->tasks);

    DB::commit();

    }catch(\Exception $ex){

    DB::rollBack();

    throw $ex;
    }

    return $this->respondCreated([
      'message'=>'Project Created Successfully',
      'project'=>new ProjectsResource($project),
    ]);
  }

  /** Retrieve a specific project
   * 
   * 
   * Returns detailed information about a project including its members, conversations, and activities
   */

    public function show(Project $project)
    {
      $project->load(['conversations.user','meetings']);

      return new ProjectResource($project);
    }

    public function update(Project $project,ProjectRequest $request,ProjectService $service)
    {
      $this->authorize('access', $project);

      if($service->requestAttributesUnchanged($project)){

        return $this
            ->respondError("You haven't changed anything");
      }

      $project->update($request->validated());

      $changedAttribute=$service->getChangedAttribute($request);

      $service->sendNotification($project);

      return $this->respondWithSuccess([
        'message'=>'Project '.$changedAttribute.' updated sucessfully',
         $changedAttribute=>$project->{$changedAttribute},
        'slug'=>$project->slug,
        'score'=>$project->score()
      ]);
    }

    /*
     * Forget the specified resource from database.
     *
     * @param  int  $project
     */
    public function destroy(Project $project)
    {
       $this->authorize('manage', $project);

       $project->delete();

       return $this->respondWithSuccess([
         'message'=>$project->name ." abandoned successfully"
       ]);
    }

    public function restore(Project $project)
    {
       $project->restore();

      return $this->respondWithSuccess([
        'message'=>$project->name ." restored successfully"
      ]);
      }

    public function delete(Project $project)
    {
      $project->forceDelete();

      return $this->respondWithSuccess([
        'message'=>"Project deleted successfully"
      ]);
   }
   
}
