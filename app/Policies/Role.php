<?php

namespace App\Policies;

use App\Enums;
use App\Models;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class Role
 */
class Role
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\Permission::CreateRoles->value);
    }

    public function replicate(Models\User $user, Models\Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * 1. 自己不能删除自己所在的角色组
     * 2. 超级管理员角色不允许被删除.
     */
    public function delete(Models\User $user, Models\Role $model): bool
    {
        if (Enums\Role::SuperAdmin->value === $model->name) {
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
     */
    public function restore(Models\User $user, Models\Role $model): bool
    {
        if ($user->hasRole($model->name) || Enums\Role::SuperAdmin->value === $model->name) {
            return false;
        }

        return $user->hasPermissionTo(Enums\Permission::RestoreRoles->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 1. 自己不能强制删除自己所在的角色组
     * 2. 超级管理员角色不允许被强制删除.
     */
    public function forceDelete(Models\User $user, Models\Role $model): bool
    {
        if ($user->hasRole($model->name) || Enums\Role::SuperAdmin->value === $model->name) {
            return false;
        }

        return $user->hasPermissionTo(Enums\Permission::ForceDeleteRoles->value);
    }

    /**
     * Determine whether the user can update the model.
     * 1. 自己不能编辑自己所在的角色组
     * 2. 超级管理员角色不允许被编辑.
     */
    public function update(Models\User $user, Models\Role $model): bool
    {
        if ($user->hasRole($model->name) || Enums\Role::SuperAdmin->value === $model->name) {
            return false;
        }

        return $user->hasPermissionTo(Enums\Permission::UpdateRoles->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Models\User $user, Models\Role $model): bool
    {
        return $user->hasPermissionTo(Enums\Permission::ViewRoles->value);
    }

    public function viewAny(Models\User $user): bool
    {
        return $user->hasPermissionTo(Enums\Permission::ManagerRoles->value);
    }

    /**
     * 角色详情页面中的用户列表新增按钮操作用户控制
     * 1. 当用户拥有附加用户权限
     * 2. 普通用不允许向超级管理员组添加用户.
     */
    public function attachAnyUser(Models\User $user, Models\Role $role): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if (Enums\Role::SuperAdmin->value === $role->name) {
            return false;
        }

        return $user->hasPermissionTo(Enums\Permission::RoleAttachAnyUsers->value);
        // && !$user->roles->contains($role)
    }

    /**
     * 角色详情页面中的用户列表更新按钮操作权限控制.
     */
    public function attachUser(Models\User $user, Models\Role $role): bool
    {
        return $user->hasPermissionTo(Enums\Permission::RoleAttachUsers->value);
    }

    /**
     * 角色详情页面中的用户列表删除按钮操作权限控制.
     */
    public function detachUser(Models\User $user, Models\Role $role): bool
    {
        return $user->hasPermissionTo(Enums\Permission::RoleDetachUsers->value);
    }
}
