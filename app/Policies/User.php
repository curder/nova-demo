<?php

namespace App\Policies;

use App\Enums;
use App\Models;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy.
 */
class User
{
    use HandlesAuthorization;

    public function before(Models\User $user, $ability)
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
    public function create(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::CreateUsers->value);
    }

    public function replicate(Models\User $user, Models\User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * 1. 不能删除其他超级管理员
     * 2. 自己不能删除自己
     * 3. 超级管理员不允许被删除.
     */
    public function delete(Models\User $user, Models\User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id && ! $model->isSuperAdmin();
        }

        return $user->can(Enums\PermissionsEnum::DeleteUsers->value) // 拥有删除用户权限
            && $user->id !== $model->id //
            && ! $model->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     * 1. 自己不能恢复自己
     * 2. 被恢复的用户不是超级管理员.
     */
    public function restore(Models\User $user, Models\User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        return $user->can(Enums\PermissionsEnum::RestoreUsers->value)
            && $user->id !== $model->id
            && ! $model->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Models\User $user, Models\User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        } else {
            if ($model->isSuperAdmin()) { // 普通管理员不允许编辑超级管理员
                return false;
            }
        }

        return $user->can(Enums\PermissionsEnum::UpdateUsers->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 1. 自己不能强制删除自己
     * 2. 被强制删除的用户不是超级管理员.
     */
    public function forceDelete(Models\User $user, Models\User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        return $user->can(Enums\PermissionsEnum::ForceDeleteUsers->value)
            && $user->id !== $model->id
            && ! $model->isSuperAdmin();
    }

    /**
     * 用户详情页面中的角色列表新增按钮操作用户控制
     * 1. 当用户拥有附加用户权限
     * 2. 普通用不允许向超级管理员组添加用户.
     */
    public function attachAnyRole(Models\User $user, Models\User $role): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if (Enums\RolesEnum::SuperAdmin->value === $role->name) {
            return false;
        }

        return $user->hasPermissionTo(Enums\PermissionsEnum::RoleAttachAnyUsers->value);
        // && !$user->roles->contains($role)
    }

    /**
     * 用户详情页面中的角色列表更新按钮操作权限控制.
     */
    public function attachRole(Models\User $user, Models\User $role): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::RoleAttachUsers->value);
    }

    /**
     * 用户详情页面中的角色列表删除按钮操作权限控制.
     */
    public function detachRole(Models\User $user, Models\User $model): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::RoleDetachUsers->value);
    }

    /**
     * 用户详情页面中的权限列表新增按钮操作权限控制.
     */
    public function attachAnyPermission(Models\User $user, Models\User $model): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        } else {
            if ($model->isSuperAdmin()) { // 普通用不允许编辑超级管理员权限
                return false;
            }
        }

        return $user->hasPermissionTo(Enums\PermissionsEnum::PermissionAttachAnyUsers->value);
        // && !$user->roles->contains($role)
    }

    /**
     * 用户详情页面中的权限列表更新按钮操作权限控制.
     */
    public function attachPermission(Models\User $user, Models\User $use): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::PermissionAttachUsers->value);
    }

    /**
     * 用户详情页面中的权限列表删除按钮操作权限控制.
     */
    public function detachPermission(Models\User $user, Models\User $model): bool
    {

        return $user->hasPermissionTo(Enums\PermissionsEnum::PermissionDetachUsers->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Models\User $user, Models\User $model): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::ViewUsers->value);
    }

    public function viewAny(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\PermissionsEnum::ManagerUsers->value);
    }
}
