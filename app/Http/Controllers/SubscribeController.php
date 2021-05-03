<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Project;

class SubscribeController extends Controller
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
