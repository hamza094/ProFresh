<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskStatus as Status; 
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\Api\V1\TaskStatusResource;
use App\Http\Requests\Api\V1\Admin\TaskStatusRequest;

class StatusController extends Controller
{
    use ApiResponseHelpers;

    public function index()
    {
      $statuses=Status::all();

      return TaskStatusResource::collection($statuses);
    }

    public function store(TaskStatusRequest $request)
    {
        $status = Status::create($request->validated());

        return $this->respondCreated([
            'message'=>'Status created successfully',
            'status'=>new TaskStatusResource($status)
        ]);
    }

    public function update(TaskStatusRequest $request,Status $status)
    {
        $status->update($request->validated());

         return $this->respondWithSuccess([
            'message'=>'Status updated successfully',
            'status'=>new TaskStatusResource($status)
        ]);
    }

    public function destroy(Status $status)
    {
      $status->delete();

      return $this->respondOk('Status deleted successfully');
    }
}
