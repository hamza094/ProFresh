<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
   public function assignRole(Role $role,Permission $permission)
   {

    if($role->hasPermissionTo($permission)){
      return "this permission already assigned to this role";
    }

    $permission->assignRole($role);

    return response()->json(['message'=>'Role assigned to permission successfully']);

   }

    public function unAssignPermission(Role $role,Permission $permission)
    {

    if(!$role->hasPermissionTo($permission)){
      return "this permission is not assigned to this role";
    }

        $role->revokePermissionTo($permission);

        return response()->json(['message'=>'Role permission revoked successfully']);

    }

    public function assignUserRole(User $user,Role $role)
    {

      if($user->hasRole($role)){
        return 'this user role is already defined';
      }

      $user->syncRoles($role);

      return response()->json(['message'=>'Role assigned to role successfully']);

    }
    
}
