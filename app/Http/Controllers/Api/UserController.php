<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UsersResource;
use App\Models\User;

class UserController extends ApiController
{
    public function index()
    {
      return UsersResource::collection(User::all());
    }

    public function show()
    {
      return response()->json([
      'user' => auth()->user(),
    ], 200);
    }
}
