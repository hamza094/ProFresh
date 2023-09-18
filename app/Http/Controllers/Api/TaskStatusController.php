<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use App\Enums\TaskDueNotifies;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __invoke()
    {
      return response()->json([
        'statuses'=>TaskStatusResource::collection(TaskStatus::all()),
        'due_notifies'=>TaskDueNotifies::values(),
      ]); 
    }

}
