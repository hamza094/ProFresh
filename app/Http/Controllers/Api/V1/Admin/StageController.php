<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StageRequest;
use App\Http\Resources\Api\V1\Admin\StageResource;
use App\Models\Stage;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\Request;

class StageController extends Controller
{
    use ApiResponseHelpers;

    public function index()
    {
        $stages = Stage::all();

        return StageResource::collection($stages);
    }

    public function store(StageRequest $request): \Illuminate\Http\JsonResponse
    {
        $stage = Stage::create($request->validated());

        return $this->respondCreated([
            'message' => 'Stage created successfully',
            'stage' => new StageResource($stage),
        ]);
    }

    public function update(Request $request, Stage $stage): \Illuminate\Http\JsonResponse
    {
        $stage->update($request->validate(['name' => 'required|string|max:255']));

        return $this->respondWithSuccess([
            'message' => 'Stage updated successfully',
            'stage' => new StageResource($stage),
        ]);
    }

    public function destroy(Stage $stage): \Illuminate\Http\JsonResponse
    {
        $stage->delete();

        return $this->respondOk('Stage deleted successfully');
    }
}
