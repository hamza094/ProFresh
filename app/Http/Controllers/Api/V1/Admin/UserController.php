<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\Api\V1\Admin\UsersResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage=7;

       $users = User::with('subscriptions','roles')
       ->withCount('projects')
       ->when($request->search, function ($query) use ($request) {
           $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('username', 'like', '%' . $request->search . '%')
            ->orWhere('email', 'like', '%' . $request->search . '%');
    })
    ->paginate($perPage);

        return UsersResource::collection($users);
    }
}
