<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\TaskDueNotifies;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TaskStatusResource;
use App\Models\TaskStatus;

class TaskStatusController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'statuses' => TaskStatusResource::collection(TaskStatus::all()),
            'due_notifies' => TaskDueNotifies::values(),
        ]);
    }
}
