<?php

declare(strict_types=1);

namespace Curder\NovaPermission\Policies;

use App\Enums\PermissionsEnum;
use App\Models\User;
use Curder\NovaPermission\Models\Permission;
use Curder\NovaPermission\Models\Role;

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
    {}

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
     *
     * @return mixed
     */
    public function delete($user, $model)
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
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ANY_USERS);
    }

    /**
     * 权限详情页面中的用户列表更新按钮操作权限控制.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function attachUser(User $user, Permission $permission)
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_USERS);
    }

    /**
     * 权限详情页面中的用户列表删除按钮操作权限控制.
     *
     * @param User       $user
     * @param Permission $permission
     *
     * @return bool
     */
    public function detachUser($user, $permission)
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_DETACH_USERS);
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
    public function attachAnyRole($user, $role)
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
    public function attachRole($user, $role)
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_ATTACH_ROLES);
    }

    /**
     * 权限详情页面中的用户列表删除角色按钮操作权限控制.
     *
     * @param User $user
     * @param Role $role
     *
     * @return bool
     */
    public function detachRole($user, $role)
    {
        return $user->hasPermissionTo(PermissionsEnum::PERMISSION_DETACH_ROLES);
    }

    /**
     * @return array
     */
    protected function disabledGroup()
    {
        return [PermissionsEnum::USERS, PermissionsEnum::ROLES, PermissionsEnum::PERMISSIONS];
    }


    /**
     * @return mixed
     */
    public static function getKey()
    {
        return 'Permissions';
    }
}
