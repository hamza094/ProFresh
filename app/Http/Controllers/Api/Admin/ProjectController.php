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

        $projects = Project::with('stage')
            ->withCount('tasks', 'activeMembers')
            ->withTrashed()
            ->orderBy('created_at',$sortDirection)
            ->get();

        $projectCount = Project::withTrashed()->count(); 

        return response()->json([
        'projects' => ProjectResource::collection($projects)
                      ->paginate($perPage),
        ]);
    }
}
