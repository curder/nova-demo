<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RolePolicy.
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CreateRoles->value);
    }

    public function replicate(User $user, \Spatie\Permission\Models\Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * 1. 自己不能删除自己所在的角色组
     * 2. 超级管理员角色不允许被删除.
     *
     * @param  User  $user
     * @param  Role  $model
     */
    public function delete($user, $model): bool
    {
        if (RolesEnum::SuperAdmin->value === $model->name) {
            return false;
        }

        if ($user->hasRole($model->name)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     * 1. 自己不能删除自己所在的角色组
     * 2. 超级管理员角色不允许被恢复.
     *
     * @param  User  $user
     * @param  Role  $model
     */
    public function restore($user, $model): bool
    {
        if ($user->hasRole($model->name) || RolesEnum::SuperAdmin->value === $model->name) {
            return false;
        }

        return $user->hasPermissionTo(PermissionsEnum::RestoreRoles->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 1. 自己不能强制删除自己所在的角色组
     * 2. 超级管理员角色不允许被强制删除.
     *
     * @param  User  $user
     * @param  Role  $model
     */
    public function forceDelete($user, $model): bool
    {
        if ($user->hasRole($model->name) || RolesEnum::SuperAdmin->value === $model->name) {
            return false;
        }

        return $user->hasPermissionTo(PermissionsEnum::ForceDeleteRoles->value);
    }

    /**
     * Determine whether the user can update the model.
     * 1. 自己不能编辑自己所在的角色组
     * 2. 超级管理员角色不允许被编辑.
     *
     * @param  User  $user
     * @param  Role  $model
     */
    public function update($user, $model): bool
    {
        if ($user->hasRole($model->name) || RolesEnum::SuperAdmin->value === $model->name) {
            return false;
        }

        return $user->hasPermissionTo(PermissionsEnum::UpdateRoles->value);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  Model  $model
     */
    public function view($user, $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ViewRoles->value);
    }

    /**
     * @param  User  $user
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ManagerRoles->value);
    }

    /**
     * 角色详情页面中的用户列表新增按钮操作用户控制
     * 1. 当用户拥有附加用户权限
     * 2. 普通用不允许向超级管理员组添加用户.
     *
     * @param  User  $user
     * @param  Role  $role
     */
    public function attachAnyUser($user, $role): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if (RolesEnum::SuperAdmin->value === $role->name) {
            return false;
        }

        return $user->hasPermissionTo(PermissionsEnum::RoleAttachAnyUsers->value);
        // && !$user->roles->contains($role)
    }

    /**
     * 角色详情页面中的用户列表更新按钮操作权限控制.
     *
     * @param  User  $user
     * @param  Role  $role
     */
    public function attachUser($user, $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::RoleAttachUsers->value);
    }

    /**
     * 角色详情页面中的用户列表删除按钮操作权限控制.
     *
     * @param  User  $user
     * @param  Role  $role
     */
    public function detachUser($user, $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::RoleDetachUsers->value);
    }
}
