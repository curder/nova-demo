<?php

declare(strict_types=1);

namespace Curder\NovaPermission\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;
use Curder\NovaPermission\Models\Permission;
use Curder\NovaPermission\Models\Role;
use Illuminate\Support\Str;

/**
 * Class PermissionPolicy.
 */
class PermissionPolicy extends Policy
{
    protected static $key = 'Permissions';

    /**
     * @param $user
     * @param $ability
     *
     * @return bool
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
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * @param $user
     * @param $model
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
     * @param  $user
     * @param $model
     *
     * @return bool
     */
    public function delete($user, $model): bool
    {
        /* @var User $user */
        if ($user->isSuperAdmin()) {
            return true;
        }
        /* @var User $user */
        return $user->hasPermissionTo('delete'.static::getKey()) && !in_array($model->group, $this->disabledGroup(), true);
    }

    /**
     * 权限详情页面中的用户列表新增按钮操作权限控制
     * 1. 当用户拥有添加用户权限.
     *
     * @param User $user
     * @param      $permission
     *
     * @return bool
     */
    public function attachAnyUser(User $user, Permission $permission)
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
    public function attachUser(User $user, Permission $permission): bool
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
    public function detachUser($user, $permission): bool
    {
        return $user->hasPermissionTo(
            PermissionsEnum::PERMISSION_DETACH_USERS->value
        );
    }

    /**
     * 权限详情页面中的用户列表新增角色按钮操作权限控制
     * 1. 当用户拥有添加用户权限.
     *
     * @param $user
     * @param $role
     *
     * @return bool
     */
    public function attachAnyRole($user, $role): bool
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES);
    }

    /**
     * 权限详情页面中的用户列表更新角色按钮操作权限控制.
     *
     * @param $user
     * @param  $role
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
    protected function disabledGroup()
    {
        return [
            PermissionsEnum::USERS->value,
            PermissionsEnum::ROLES->value,
            PermissionsEnum::PERMISSIONS->value
        ];
    }

    /**
     * @return string
     */
    public static function getKey(): string
    {
        return Str::studly(PermissionsEnum::PERMISSIONS->value);
    }
}
