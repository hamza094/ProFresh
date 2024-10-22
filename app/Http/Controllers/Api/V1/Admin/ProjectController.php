<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Resources\Api\V1\Admin\ProjectResource;
use App\Http\Controllers\Api\ApiController;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Repository\Admin\ProjectFiltersRepository;
use App\Http\Requests\Api\V1\Admin\ProjectFilterRequest;

class ProjectController extends ApiController
{
    use ApiResponseHelpers;

    public function index(ProjectFilterRequest $request,ProjectFiltersRepository $repository): JsonResponse
    {
        $perPage = 10;
        $appliedFilters = [];

       $data = $repository->filters($request,$perPage,$appliedFilters);

       $projects=$data['projects'];
       $appliedFilters=$data['appliedFilters'];

    if($projects->isEmpty()){
         return $this->respondWithSuccess([
        'message'=>'Sorry no result found',
        'appliedFilters' => $appliedFilters,
    ]);
         
    }

    return $this->respondWithSuccess([
        'projects'=>ProjectResource::collection($projects)->paginate($perPage),
        'appliedFilters' => $appliedFilters,
    ]);     
    }

    public function bulkDelete(Request $request)
    {
        $projectIds = $request->input('project_ids', []);

        Project::withTrashed()->whereIn('id', $projectIds)->each(function ($project) {
    $project->forceDelete();
    });

        return $this->respondWithSuccess([
        'message'=>'Projects deleted Successfully',
    ]); 

    }
}
