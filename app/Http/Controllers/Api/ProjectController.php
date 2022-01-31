<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectScore;
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
      //$score_sum=$project->scores()->sum('point');

      //$conversation_count=$project->group->conversations->count();

      /*return view('project.show',compact('project',$project,'score_sum',$score_sum,
          'conversation_count',$conversation_count));*/

          return new ProjectResource($project);


    }

    public function update(Project $project,ProjectRequest $request)
    {
      $this->authorize('access',$project);

      $project->update($request->validated());

      $this->sendNotification($project,new ProjectUpdated($project));

      if (request()->wantsJson()) {
            return response($project, 201);
        }
    }

    /**
     * Forget the specified resource from database.
     *
     * @param  int  $project
     */
    public function destroy(Project $project)
    {
      //$this->authorize('manage',$project);
        $project->delete();
    }

    public function delete(Project $project)
    {
      $this->authorize('manage',$project);

      $project->forceDelete();

      $appointment->activity()->delete();

        if(request()->expectsJson()){
            return response(['status'=>'project deleted']);
      }
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
