<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Notifications\ProjectUpdated;
use App\Services\ProjectService;
use App\Repository\ProjectRepository;
use App\Http\Resources\ProjectResource;
use Illuminate\Support\Facades\DB;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
  use ApiResponseHelpers;

  private $projectService;

  /**
    * Service For Project Feature
    *
    * App\Service\FeatureService
    */
  public function __construct(ProjectService $projectService)
  {
    $this->projectService=$projectService;
  }

    public function store(ProjectRequest $request)
    {

       DB::beginTransaction();

       try{

        $project = Auth::user()->projects()->create($request->validated());

        $this->projectService->createProjectGroupChat($project);

        DB::commit();

       }catch(\Exception $ex){

        DB::rollBack();

        throw $ex;
       }

       if(request()->wantsJson()){
        return['message'=>$project->path()];
    }
}

    public function show(Project $project)
    {
       //$conversation_count=$project->group->conversations->count();
       return new ProjectResource($project);
    }

    public function update(Project $project,ProjectRequest $request,ProjectService $service)
    {
      $this->authorize('access', $project);

      if($service->sameRequestAttributes($project) || $service->sameNoteRequest($project)){
         return $this->respondError("You haven't changed anything");
      }

      $project->update($request->validated());

      $requestArray=$request->input();

      $key=array_key_first($requestArray);

      $value=$project->$key;

      return $this->respondWithSuccess(
        ['msg'=>'Project '.$key.' updated sucessfully', $key=>$value,'slug'=>$project->slug]
      );

      //$this->sendNotification($project,new ProjectUpdated($project));
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
      $name=$project->name;

      $project->forceDelete();

      return $this->respondWithSuccess([
        'message'=>"Project " .$name. " deleted successfully"
      ]);
   }

    /**
     * Filter project related activities.
     *
     * @param  int  $project
    */
    public function activity(Project $project)
    {
      $activities=$project->activity();

      $repository=new ProjectRepository();

      $repository->filterProjectActivity($activities);

      $activities = $activities->paginate(10);

      return view('project.activities.activities',compact('activities',$activities,'project',$project));
     }

     public function overview(){

     }
}
