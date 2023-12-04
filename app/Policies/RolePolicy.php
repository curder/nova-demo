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
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * 1. 自己不能删除自己所在的角色组
     * 2. 超级管理员角色不允许被删除.
     *
     * @param User $user
     * @param Role $model
     *
     * @return bool
     */
    public function delete($user, $model)
    {
        if (RolesEnum::SUPER_ADMIN === $model->name) {
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
     * @param User $user
     * @param Role $model
     *
     * @return mixed
     */
    public function restore($user, $model)
    {
        return false;

        //        if ($user->hasRole($model->name) || RolesEnum::SUPER_ADMIN === $model->name) {
        //            return false;
        //        }
        //
        //        return $user->hasPermissionTo(PermissionsEnum::RESTORE_ROLES);
    }

    /**
     * Determine whether the user can permanently delete the model.
     * 1. 自己不能强制删除自己所在的角色组
     * 2. 超级管理员角色不允许被强制删除.
     *
     * @param User $user
     * @param Role $model
     *
     * @return mixed
     */
    public function forceDelete($user, $model)
    {
        return false;
        //        if ($user->hasRole($model->name) || RolesEnum::SUPER_ADMIN === $model->name) {
        //            return false;
        //        }
        //
        //        return $user->hasPermissionTo(PermissionsEnum::FORCE_DELETE_ROLES);
    }

    /**
     * Determine whether the user can update the model.
     * 1. 自己不能编辑自己所在的角色组
     * 2. 超级管理员角色不允许被编辑.
     *
     * @param User $user
     * @param Role $model
     *
     * @return mixed
     */
    public function update($user, $model)
    {
        return false;
        //        /* @var User $user */
        //        if ($user->hasRole($model->name) || RolesEnum::SUPER_ADMIN === $model->name) {
        //            return false;
        //        }
        //
        //        return $user->hasPermissionTo(PermissionsEnum::UPDATE_ROLES);
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
        return $user->hasPermissionTo(PermissionsEnum::VIEW_ROLES);
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function viewAny($user): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::MANAGER_ROLES);
    }

    /**
     * 角色详情页面中的用户列表新增按钮操作用户控制
     * 1. 当用户拥有附加用户权限
     * 2. 普通用不允许向超级管理员组添加用户.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function attachAnyUser($user, $role)
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
     * 角色详情页面中的用户列表更新按钮操作权限控制.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function attachUser($user, $role)
    {
        return $user->hasPermissionTo(PermissionsEnum::ROLE_ATTACH_USERS);
    }

    /**
     * 角色详情页面中的用户列表删除按钮操作权限控制.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function detachUser($user, $role)
    {
        return $user->hasPermissionTo(PermissionsEnum::ROLE_DETACH_USERS);
    }
}
