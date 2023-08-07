<?php

namespace App\Policies;

use App\Enums;
use App\Models;

/**
 * Class Permission.
 */
class Permission
{
    public function create(Models\User $user): bool
    {
        return false;
    }

    public function update(Models\User $user, Models\Permission $model): bool
    {
        return false;
    }

    public function delete(Models\User $user, Models\Permission $model): bool
    {
        return false;
    }

    public function view(Models\User $user, Models\Permission $model): bool
    {
        return $user->hasPermissionTo(Enums\Permission::ViewPermissions->value);
    }

    public function viewAny(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\Permission::ManagerPermissions->value);
    }

    /**
     * 权限详情页面中的用户列表新增按钮操作权限控制
     * 当用户拥有添加用户权限.
     */
    public function attachAnyUser(Models\User $user, Models\Permission $permission): bool
    {
        return $user->hasPermissionTo(Enums\Permission::PermissionAttachAnyUsers->value);
    }

    /**
     * 权限详情页面中的用户列表更新按钮操作权限控制.
     */
    public function attachUser(Models\User $user, Models\Permission $permission): bool
    {
        return $user->hasPermissionTo(Enums\Permission::PermissionAttachUsers->value);
    }

    /**
     * 权限详情页面中的用户列表删除按钮操作权限控制.
     */
    public function detachUser(Models\User $user, Models\Permission $permission): bool
    {
        return $user->hasPermissionTo(Enums\Permission::PermissionDetachUsers->value);
    }

    /**
     * 权限详情页面中的用户列表新增角色按钮操作权限控制
     * 1. 当用户拥有添加用户权限.
     */
    public function attachAnyRole(Models\User $user, Models\Role $role): bool
    {
        return $user->hasPermissionTo(Enums\Permission::PermissionAttachAnyRoles->value);
    }

    /**
     * 权限详情页面中的用户列表更新角色按钮操作权限控制.
     */
    public function attachRole(Models\User $user, Models\Role $role): bool
    {
        return $user->hasPermissionTo(Enums\Permission::PermissionAttachRoles->value);
    }

    /**
     * 权限详情页面中的用户列表删除角色按钮操作权限控制.
     */
    public function detachRole(Models\User $user, Models\Role $role): bool
    {
        return $user->hasPermissionTo(Enums\Permission::PermissionDetachRoles->value);
    }

    protected function disabledGroup(): array
    {
        return [
            Enums\Permission::Users->value,
            Enums\Permission::Roles->value,
            Enums\Permission::Permissions->value,
        ];
    }
}
