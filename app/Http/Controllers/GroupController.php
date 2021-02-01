<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Project;

class GroupController extends Controller
{
  public function store(Project $project)
 {
    $group = Group::create(['name' => request('name')]);
     $users=[];
    foreach ($project->members->where('pivot.active',1) as $user) {
            $users[] = $user->id;
        }
     array_push($users, $project->user->id);

     $group->users()->attach($users);

     return $group;
 }
}
