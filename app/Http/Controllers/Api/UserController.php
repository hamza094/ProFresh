<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResourceCollection;
use App\Models\User;

class UserController extends ApiController
{
    public function index()
    {
        $users=User::all();

        return new UserResourceCollection($users);
    }

    public function show()
    {
      return response()->json([
      'user' => auth()->user(),
    ], 200);
    }
}
