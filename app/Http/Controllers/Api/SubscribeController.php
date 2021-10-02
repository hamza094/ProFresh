<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;

class SubscribeController extends ApiController
{
  public function projectSubscribe(Project $project)
  {
     $project->subscribe();
  }

  public function projectUnSubscribe(Project $project)
  {
     $project->unsubscribe();
  }

}
