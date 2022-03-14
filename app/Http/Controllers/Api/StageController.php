<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\StageResource;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
  use ApiResponseHelpers;

    public function index(){
      $stages=Stage::all();
      return StageResource::collection($stages);
    }
}
