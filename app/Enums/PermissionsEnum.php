<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;
use BenSampo\Enum\Contracts\LocalizedEnum;
use App\Enums\PermissionsEnum as Permission;

final class PermissionsEnum extends Enum implements LocalizedEnum
{
    // 用户
    public const USERS = 'users'; // 分组标示
    public const MANAGER_USERS = 'managerUsers'; // 列表
    public const VIEW_USERS = 'viewUsers'; // 查看
    public const CREATE_USERS = 'createUsers'; // 新建
    public const UPDATE_USERS = 'updateUsers'; // 编辑
    public const DELETE_USERS = 'deleteUsers'; // 删除
    public const RESTORE_USERS = 'restoreUsers'; // 恢复删除
    public const FORCE_DELETE_USERS = 'forceDeleteUsers'; // 强制删除
    public const PERMISSION_ATTACH_ANY_USERS = 'attachAnyUsers'; // 赋予用户权限
    public const PERMISSION_ATTACH_USERS = 'attachUsers'; // 更新用户权限
    public const PERMISSION_DETACH_USERS = 'detachUsers';    // 取消用户授权

    // 角色
    public const ROLES = 'roles'; // 分组标示
    public const MANAGER_ROLES = 'managerRoles'; // 列表
    public const VIEW_ROLES = 'viewRoles'; // 查看
    public const CREATE_ROLES = 'createRoles'; // 新建
    public const UPDATE_ROLES = 'updateRoles'; // 编辑
    public const DELETE_ROLES = 'deleteRoles'; // 删除
    public const RESTORE_ROLES = 'restoreRoles'; // 恢复删除
    public const FORCE_DELETE_ROLES = 'forceDeleteRoles'; // 强制删除
    public const ROLE_ATTACH_ANY_USERS = 'roleAttachAnyUsers'; // 赋予用户角色
    public const ROLE_ATTACH_USERS = 'roleAttachUsers'; // 更新用户角色
    public const ROLE_DETACH_USERS = 'roleDetachUsers'; // 取消用户角色

    // 权限
    public const PERMISSIONS = 'permissions'; // 分组标示
    public const MANAGER_PERMISSIONS = 'managerPermissions'; // 列表
    public const VIEW_PERMISSIONS = 'viewPermissions'; // 查看
    //    public const CREATE_PERMISSIONS = 'createPermissions'; // 新建
    //    public const UPDATE_PERMISSIONS = 'updatePermissions'; // 编辑
    public const DELETE_PERMISSIONS = 'deletePermissions'; // 删除
    public const RESTORE_PERMISSIONS = 'restorePermissions'; // 恢复删除
    public const FORCE_DELETE_PERMISSIONS = 'forceDeletePermissions'; // 强制删除
    public const PERMISSION_ATTACH_ANY_ROLES = 'permissionAttachAnyRoles'; // 赋予角色权限
    public const PERMISSION_ATTACH_ROLES = 'permissionAttachRoles'; // 更新角色权限
    public const PERMISSION_DETACH_ROLES = 'permissionDetachRoles'; // 取消赋予角色权限

    // 菜单
    public const MENUS = 'menus'; // 菜单
    public const MANAGER_MENUS = 'managerMenus'; // 列表
    public const VIEW_MENUS = 'viewMenus'; // 查看
    public const CREATE_MENUS = 'createMenus'; // 新建
    public const UPDATE_MENUS = 'updateMenus'; // 编辑
    public const DELETE_MENUS = 'deleteMenus'; // 删除

    /**
     * 所有可用权限
     *
     * @return Collection
     */
    public static function availablePermissions(): Collection
    {
        return collect(Permission::getInstances())
            ->reject(fn (Permission $item) => array_key_exists($item->value, Permission::groups()))
            ->pluck('value');
    }

    /**
     * @return array
     */
    public static function groups(): array
    {
        $groups = [
            self::USERS,
            self::ROLES,
            self::PERMISSIONS,
            self::MENUS,
        ];

        return collect($groups)->mapWithKeys(fn($key) => [$key => self::fromValue($key)->description])->toArray();
    }

    public static function count(): int
    {
        return self::availablePermissions()->count();
    }
}
