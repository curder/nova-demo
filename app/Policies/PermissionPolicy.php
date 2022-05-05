<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PermissionPolicy.
 */
class PermissionPolicy
{
    /**
     * @param User $user
     * @param string $ability
     *
     * @return null|bool
     */
    public function before($user, $ability)
    {
        //
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function create($user): bool
    {
        return false;
    }

    /**
     * @param User $user
     * @param Permission $model
     *
     * @return bool
     */
    public function update($user, $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Permission $model
     *
     * @return bool
     */
    public function delete($user, $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Model $model
     *
     * @return bool
     */
    public function view($user, $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_PERMISSIONS->value);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::MANAGER_PERMISSIONS->value);
    }

    /**
     * 权限详情页面中的用户列表新增按钮操作权限控制
     * 1. 当用户拥有添加用户权限.
     *
     * @param User $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function attachAnyUser($user, Permission $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PERMISSION_ATTACH_ANY_USERS->value
        );
    }

    /**
     * 权限详情页面中的用户列表更新按钮操作权限控制.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function attachUser($user, Permission $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PERMISSION_ATTACH_USERS->value
        );
    }

    /**
     * 权限详情页面中的用户列表删除按钮操作权限控制.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function detachUser($user, Permission $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PERMISSION_DETACH_USERS->value
        );
    }

    /**
     * 权限详情页面中的用户列表新增角色按钮操作权限控制
     * 1. 当用户拥有添加用户权限.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function attachAnyRole($user, $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES->value);
    }

    /**
     * 权限详情页面中的用户列表更新角色按钮操作权限控制.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function attachRole($user, $role): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PERMISSION_ATTACH_ROLES->value
        );
    }

    /**
     * 权限详情页面中的用户列表删除角色按钮操作权限控制.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function detachRole($user, $role): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PERMISSION_DETACH_ROLES->value
        );
    }

    /**
     * @return array
     */
    protected function disabledGroup(): array
    {
        return [
            PermissionsEnum::USERS->value,
            PermissionsEnum::ROLES->value,
            PermissionsEnum::PERMISSIONS->value,
        ];
    }
}
