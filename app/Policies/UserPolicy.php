<?php

namespace App\Policies;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPolicy.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param  User  $user
     * @param  string  $ability
     * @return bool|null
     */
    public function before($user, $ability)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     *
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CreateUsers->value);
    }

    public function replicate(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * 1. 不能删除其他超级管理员
     * 2. 自己不能删除自己
     * 3. 超级管理员不允许被删除.
     *
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function delete($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id && ! $model->isSuperAdmin();
        }

        return $user->can(PermissionsEnum::DeleteUsers->value) // 拥有删除用户权限
            && $user->id !== $model->id //
            && ! $model->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     * 1. 自己不能恢复自己
     * 2. 被恢复的用户不是超级管理员.
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function restore($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        return $user->can(PermissionsEnum::RestoreUsers->value)
            && $user->id !== $model->id
            && ! $model->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function update($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        } else {
            if ($model->isSuperAdmin()) { // 普通管理员不允许编辑超级管理员
                return false;
            }
        }

        return $user->can(PermissionsEnum::UpdateUsers->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 1. 自己不能强制删除自己
     * 2. 被强制删除的用户不是超级管理员.
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function forceDelete($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        return $user->can(PermissionsEnum::ForceDeleteUsers->value)
            && $user->id !== $model->id
            && ! $model->isSuperAdmin();
    }

    /**
     * 用户详情页面中的角色列表新增按钮操作用户控制
     * 1. 当用户拥有附加用户权限
     * 2. 普通用不允许向超级管理员组添加用户.
     *
     * @param  User  $user
     * @param  Role  $role
     */
    public function attachAnyRole($user, $role): bool
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
     * 用户详情页面中的角色列表更新按钮操作权限控制.
     *
     * @param  User  $user
     * @param  Role  $role
     */
    public function attachRole($user, $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::RoleAttachUsers->value);
    }

    /**
     * 用户详情页面中的角色列表删除按钮操作权限控制.
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function detachRole($user, $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::RoleDetachUsers->value);
    }

    /**
     * 用户详情页面中的权限列表新增按钮操作权限控制.
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function attachAnyPermission($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        } else {
            if ($model->isSuperAdmin()) { // 普通用不允许编辑超级管理员权限
                return false;
            }
        }

        return $user->hasPermissionTo(PermissionsEnum::PermissionAttachAnyUsers->value);
        // && !$user->roles->contains($role)
    }

    /**
     * 用户详情页面中的权限列表更新按钮操作权限控制.
     *
     * @param  User  $user
     * @param  Permission  $permission
     */
    public function attachPermission($user, $permission): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PermissionAttachUsers->value);
    }

    /**
     * 用户详情页面中的权限列表删除按钮操作权限控制.
     *
     * @param  User  $user
     * @param  Permission  $permission
     */
    public function detachPermission($user, $permission): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PermissionDetachUsers->value);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  User  $user
     * @param  User  $model
     */
    public function view($user, $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ViewUsers->value);
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ManagerUsers->value);
    }
}
