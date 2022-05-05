<?php

namespace App\Enums;

use App\Enums\PermissionsEnum as Permission;
use Illuminate\Support\Collection;

enum PermissionsEnum: string
{
    // 用户
    case USERS = 'users'; // 分组标示
    case MANAGER_USERS = 'managerUsers'; // 列表
    case VIEW_USERS = 'viewUsers'; // 查看
    case CREATE_USERS = 'createUsers'; // 新建
    case UPDATE_USERS = 'updateUsers'; // 编辑
    case DELETE_USERS = 'deleteUsers'; // 删除
    case RESTORE_USERS = 'restoreUsers'; // 恢复删除
    case FORCE_DELETE_USERS = 'forceDeleteUsers'; // 强制删除
    case PERMISSION_ATTACH_ANY_USERS = 'attachAnyUsers'; // 赋予用户权限
    case PERMISSION_ATTACH_USERS = 'attachUsers'; // 更新用户权限
    case PERMISSION_DETACH_USERS = 'detachUsers';    // 取消用户授权

    // 角色
    case ROLES = 'roles'; // 分组标示
    case MANAGER_ROLES = 'managerRoles'; // 列表
    case VIEW_ROLES = 'viewRoles'; // 查看
    case CREATE_ROLES = 'createRoles'; // 新建
    case UPDATE_ROLES = 'updateRoles'; // 编辑
    case DELETE_ROLES = 'deleteRoles'; // 删除
    case RESTORE_ROLES = 'restoreRoles'; // 恢复删除
    case FORCE_DELETE_ROLES = 'forceDeleteRoles'; // 强制删除
    case ROLE_ATTACH_ANY_USERS = 'roleAttachAnyUsers'; // 赋予用户角色
    case ROLE_ATTACH_USERS = 'roleAttachUsers'; // 更新用户角色
    case ROLE_DETACH_USERS = 'roleDetachUsers'; // 取消用户角色

    // 权限
    case PERMISSIONS = 'permissions'; // 分组标示
    case MANAGER_PERMISSIONS = 'managerPermissions'; // 列表
    case VIEW_PERMISSIONS = 'viewPermissions'; // 查看
    //    case CREATE_PERMISSIONS = 'createPermissions'; // 新建
    //    case UPDATE_PERMISSIONS = 'updatePermissions'; // 编辑
    case DELETE_PERMISSIONS = 'deletePermissions'; // 删除
    case RESTORE_PERMISSIONS = 'restorePermissions'; // 恢复删除
    case FORCE_DELETE_PERMISSIONS = 'forceDeletePermissions'; // 强制删除
    case PERMISSION_ATTACH_ANY_ROLES = 'permissionAttachAnyRoles'; // 赋予角色权限
    case PERMISSION_ATTACH_ROLES = 'permissionAttachRoles'; // 更新角色权限
    case PERMISSION_DETACH_ROLES = 'permissionDetachRoles'; // 取消赋予角色权限

    // 菜单
    case MENUS = 'menus'; // 菜单
    case MANAGER_MENUS = 'managerMenus'; // 列表
    case VIEW_MENUS = 'viewMenus'; // 查看
    case CREATE_MENUS = 'createMenus'; // 新建
    case UPDATE_MENUS = 'updateMenus'; // 编辑
    case DELETE_MENUS = 'deleteMenus'; // 删除

    public function label(): string
    {
        return match ($this) {
            self::MANAGER_USERS, self::MANAGER_ROLES, self::MANAGER_PERMISSIONS, self::MANAGER_MENUS => '列表',
            self::VIEW_USERS, self::VIEW_ROLES, self::VIEW_PERMISSIONS, self::VIEW_MENUS => '查看',
            self::CREATE_USERS, self::CREATE_ROLES, self::CREATE_MENUS => '新建',
            self::UPDATE_USERS, self::UPDATE_ROLES, self::UPDATE_MENUS => '编辑',
            self::DELETE_USERS, self::DELETE_ROLES, self::DELETE_PERMISSIONS, self::DELETE_MENUS => '删除',
            self::RESTORE_USERS, self::RESTORE_ROLES, self::RESTORE_PERMISSIONS => '恢复删除',
            self::FORCE_DELETE_USERS, self::FORCE_DELETE_ROLES, self::FORCE_DELETE_PERMISSIONS => '强制删除',
            self::PERMISSION_ATTACH_ANY_USERS => '赋予用户权限',
            self::PERMISSION_ATTACH_USERS => '更新用户权限',
            self::PERMISSION_DETACH_USERS => '取消用户授权',

            self::USERS => '用户',

            self::ROLES => '角色',
            self::ROLE_ATTACH_ANY_USERS => '赋予用户角色',
            self::ROLE_ATTACH_USERS => '更新用户角色',
            self::ROLE_DETACH_USERS => '取消用户角色',

            self::PERMISSIONS => '权限',
            self::PERMISSION_ATTACH_ANY_ROLES => '赋予角色权限',
            self::PERMISSION_ATTACH_ROLES => '更新角色权限',
            self::PERMISSION_DETACH_ROLES => '取消赋予角色权限',

            self::MENUS => '菜单',
        };
    }

    /**
     * 所有可用权限
     *
     * @return Collection
     */
    public static function availablePermissions(): Collection
    {
        return collect(Permission::cases())
            ->reject(fn (Permission $item) => array_key_exists($item->value, Permission::groups()))
            ->pluck('value');
    }

    /**
     * @return array
     */
    public static function groups(): array
    {
        return [
            self::USERS->value => self::USERS->label(),
            self::ROLES->value => self::ROLES->label(),
            self::PERMISSIONS->value => self::PERMISSIONS->label(),
            self::MENUS->value => self::MENUS->label(),
        ];
    }

    public static function count(): int
    {
        return self::availablePermissions()->count();
    }
}
