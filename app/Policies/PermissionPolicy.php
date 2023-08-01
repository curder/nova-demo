<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

/**
 * Class PermissionPolicy.
 */
class PermissionPolicy
{
    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Permission $model): bool
    {
        return false;
    }

    public function delete(User $user, Permission $model): bool
    {
        return false;
    }

    public function view(User $user, Permission $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ViewPermissions->value);
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ManagerPermissions->value);
    }

    /**
     * 权限详情页面中的用户列表新增按钮操作权限控制
     * 当用户拥有添加用户权限.
     */
    public function attachAnyUser(User $user, Permission|\Spatie\Permission\Models\Permission $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PermissionAttachAnyUsers->value
        );
    }

    /**
     * 权限详情页面中的用户列表更新按钮操作权限控制.
     */
    public function attachUser(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PermissionAttachUsers->value
        );
    }

    /**
     * 权限详情页面中的用户列表删除按钮操作权限控制.
     */
    public function detachUser(User $user, Permission $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PermissionDetachUsers->value
        );
    }

    /**
     * 权限详情页面中的用户列表新增角色按钮操作权限控制
     * 1. 当用户拥有添加用户权限.
     */
    public function attachAnyRole(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PermissionAttachAnyRoles->value);
    }

    /**
     * 权限详情页面中的用户列表更新角色按钮操作权限控制.
     */
    public function attachRole(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PermissionAttachRoles->value
        );
    }

    /**
     * 权限详情页面中的用户列表删除角色按钮操作权限控制.
     */
    public function detachRole(User $user, Role $role): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PermissionDetachRoles->value
        );
    }

    protected function disabledGroup(): array
    {
        return [
            PermissionsEnum::Users->value,
            PermissionsEnum::Roles->value,
            PermissionsEnum::Permissions->value,
        ];
    }
}
