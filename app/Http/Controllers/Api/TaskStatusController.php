<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskStatusResource;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __invoke()
    {
      return TaskStatusResource::collection(TaskStatus::all());
    }

}
