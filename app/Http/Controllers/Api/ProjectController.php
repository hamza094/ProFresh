<?php

namespace App\Http\Controllers\Api;

use Auth;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\ProjectStoreRequest;
use App\Helpers\SendNotification;
use App\Services\ProjectService;
use App\Repository\ProjectRepository;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\DB;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
  use ApiResponseHelpers;

  private $notification;

  /**
    * Service For Project Feature
    *
    * App\Service\FeatureService
    */
  public function __construct(SendNotification $notification)
  {
    $this->notification=$notification;
  }

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

    return $this->respondWithSuccess([
      'path'=>$project->path(),
      'slug'=>$project->slug
    ]);
  }

    public function show(Project $project)
    {
      $project->load(['tasks','conversations.user']);

      return new ProjectResource($project);
    }

    public function update(Project $project,ProjectRequest $request,ProjectService $service,SendNotification $notification)
    {
      $this->authorize('access', $project);

      if($service->requestAttributesUnchanged($project)){

        return $this
            ->respondError("You haven't changed anything");
      }

      $project->update($request->validated());

      $changedAttribute=$service->getChangedAttribute($request);

      $value=$project->$changedAttribute;

      $this->notification->send($project);

      return $this->respondWithSuccess([
        'msg'=>'Project '.$changedAttribute.' updated sucessfully',
         $changedAttribute=>$value,
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
