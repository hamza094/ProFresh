<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Api\ApiController;

class AuthenticationController extends ApiController
{
    public function user()
    {
        return auth()->user();
    }
}
