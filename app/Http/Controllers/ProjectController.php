<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Project;
use App\ProjectScore;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Notifications\ProjectUpdated;
use App\Service\ProjectService;
use App\Repository\ProjectRepository;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    private $projectService;

  /**
    /* Service For Project Feature 
     * App\Service\FeatureService
    */
  public function __construct(ProjectService $projectService){
   $this->projectService=$projectService;
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $project
     */
    public function show(Project $project)
    {
        $score_sum=$project->scores()->sum('point');

        $conversation_count=$project->group->conversations->count();

        return view('project.show',compact('project',$project,'score_sum',$score_sum,
          'conversation_count',$conversation_count));          
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Project $project,ProjectRequest $request)
    {
        $this->authorize('access',$project);

        $project->update($request->validated());

        $this->sendNotificationToMember($project);

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
      $this->authorize('manage',$project);
        $project->delete();
    }

     /**
     * Delete the specified resource from database.
     *
     * @param  int  $project
     */
    public function delete(Project $project)
    {
     $this->authorize('manage',$project);

     $project->forceDelete();
     
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
}