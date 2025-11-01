<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Admin\RoleResource;
use App\Http\Resources\Api\V1\Admin\UsersResource;
use App\Models\User;
use F9Web\ApiResponseHelpers;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    use ApiResponseHelpers;

    public function assignRolePermission(Role $role, Permission $permission)
    {
        throw_if($role->hasPermissionTo($permission),
            ValidationException::withMessages(
                ['permission' => 'This permission already assigned to this role']));

        $permission->assignRole($role);

        $role->load('permissions');

        return $this->respondWithSuccess([
            'message' => 'Role assigned to permission successfully',
            'role' => new RoleResource($role),
        ]);

    }

    public function unAssignPermission(Role $role, Permission $permission)
    {
        throw_if(! $role->hasPermissionTo($permission),
            ValidationException::withMessages(
                ['permission' => 'This permission is not assigned to this role']));

        $role->revokePermissionTo($permission);

        $role->load('permissions');

        return $this->respondWithSuccess([
            'message' => 'Role permission revoked successfully',
            'role' => new RoleResource($role),
        ]);

    }

    public function assignUserRole(User $user, Role $role)
    {
        throw_if($user->hasRole($role),
            ValidationException::withMessages(
                ['role' => 'This user role is already defined']));

        $user->syncRoles($role);

        $user->load('subscriptions', 'roles');

        $user->loadCount('projects');

        return $this->respondWithSuccess([
            'message' => 'Role assigned to user successfully',
            'user' => new UsersResource($user),
        ]);

    }
}
