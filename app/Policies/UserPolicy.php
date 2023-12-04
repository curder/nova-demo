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
     * @param User $user
     * @param string $ability
     *
     * @return bool|null
     */
    public function before($user, $ability)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::CREATE_USERS);
    }

    /**
     * Determine whether the user can delete the model.
     * 1. 不能删除其他超级管理员
     * 2. 自己不能删除自己
     * 3. 超级管理员不允许被删除.
     *
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function delete($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id && ! $model->isSuperAdmin();
        }

        return $user->can(PermissionsEnum::DELETE_USERS) // 拥有删除用户权限
            && $user->id !== $model->id //
            && ! $model->isSuperAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     * 1. 自己不能恢复自己
     * 2. 被恢复的用户不是超级管理员.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function restore($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        return $user->can(PermissionsEnum::RESTORE_USERS)
            && $user->id !== $model->id
            && ! $model->isSuperAdmin();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
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

        return $user->can(PermissionsEnum::UPDATE_USERS);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 1. 自己不能强制删除自己
     * 2. 被强制删除的用户不是超级管理员.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function forceDelete($user, $model): bool
    {
        if ($user->isSuperAdmin()) {
            return $user->id !== $model->id;
        }

        return $user->can(PermissionsEnum::FORCE_DELETE_USERS)
            && $user->id !== $model->id
            && ! $model->isSuperAdmin();
    }

    /**
     * 用户详情页面中的角色列表新增按钮操作用户控制
     * 1. 当用户拥有附加用户权限
     * 2. 普通用不允许向超级管理员组添加用户.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function attachAnyRole($user, $role): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        if (RolesEnum::SUPER_ADMIN === $role->name) {
            return false;
        }

        return $user->hasPermissionTo(PermissionsEnum::ROLE_ATTACH_ANY_USERS)
            // && !$user->roles->contains($role)
        ;
    }

    /**
     * 用户详情页面中的角色列表更新按钮操作权限控制.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function attachRole($user, $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ROLE_ATTACH_USERS);
    }

    /**
     * 用户详情页面中的角色列表删除按钮操作权限控制.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function detachRole($user, $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::ROLE_DETACH_USERS);
    }

    /**
     * 用户详情页面中的权限列表新增按钮操作权限控制.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
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

        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_USERS)
            // && !$user->roles->contains($role)
        ;
    }

    /**
     * 用户详情页面中的权限列表更新按钮操作权限控制.
     *
     * @param User $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function attachPermission($user, $permission): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_USERS);
    }

    /**
     * 用户详情页面中的权限列表删除按钮操作权限控制.
     *
     * @param User $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function detachPermission($user, $permission): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_DETACH_USERS);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     *
     * @return bool
     */
    public function view($user, $model): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::VIEW_USERS);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::MANAGER_USERS);
    }
}
