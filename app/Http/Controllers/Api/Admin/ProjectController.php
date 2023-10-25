<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Resources\Admin\ProjectResource;
use App\Http\Controllers\Api\ApiController;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class ProjectController extends ApiController
{
    use ApiResponseHelpers;

    public function index(Request $request){
        $perPage = 10;

        $sortDirection = $request->input('sort');
        $searchTerm = $request->input('search');
        $filterBy = $request->input('filter');
        $activeMembers = $request->input('members');
        $status = $request->input('status');
        $tasks = $request->input('tasks');
        $stage = $request->input('stage');
        $startdate = $request->input('from');
        $enddate = $request->input('to');

        $projects = Project::with('stage')
            ->withCount('tasks', 'activeMembers')
            ->withTrashed()
             ->when($sortDirection, function ($query) use ($sortDirection) {
           $query->orderBy('created_at', $sortDirection);
            })
             ->when($searchTerm, function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%$searchTerm%")
                ->orWhereHas('user', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%$searchTerm%")
                        ->orWhere('username', 'like', "%$searchTerm%");
                });
        })
          ->when($filterBy === "active", function ($query) {
        $query->whereNull('deleted_at'); 
       })
        ->when($filterBy === "trashed", function ($query) {
    $query->whereNotNull('deleted_at'); 
    })
      ->when($activeMembers, function ($query) {
         $query->whereHas('members', function ($subQuery) {
        $subQuery->where('project_members.active', true);
    }); 
    })
    ->when($tasks, function ($query) {
    $query->has('tasks'); 
    })
    ->when($stage, function ($query) use($stage) {
    $query->where('stage_id',$stage); 
    })
    ->when($startdate && $enddate, function ($query) use ($startdate, $enddate) {
      $query->whereBetween('created_at', [$startdate, $enddate]);
    })
    ->get();

    if ($status) {
    $filteredProjects = $projects->filter(function ($project) use ($status) {
        return $project->status === $status;
    });

    $projects = $filteredProjects;
    }
          
        return ProjectResource::collection($projects)->paginate($perPage);

    }
}
