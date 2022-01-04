<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends ApiController
{
    public function users()
    {
        return User::latest()->get();
    }

    public function user()
    {
      return response()->json([
      'user' => auth()->user(),
    ], 200);
    }
}
