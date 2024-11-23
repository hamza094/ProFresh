<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\StageResource;
use Illuminate\Http\Request;
use App\Models\Stage;

class StageController extends Controller
{
    /**
     * Display a listing of the stages.
     *
     * Fetch and return all stages that a project can be assigned to.
     *
     */
    public function index()
    {
        $stages = Stage::all();
        return StageResource::collection($stages);
    }
}
