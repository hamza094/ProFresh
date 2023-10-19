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
        ->get();

        return response()->json([
        'projects' => ProjectResource::collection($projects)
                      ->paginate($perPage),
        ]);
    }
}
