<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum Permission: string
{
    use Traits\InteractsWithOptions;

    // 用户
    case Users = 'users'; // 分组标示
    case ManagerUsers = 'managerUsers'; // 列表
    case ViewUsers = 'viewUsers'; // 查看
    case CreateUsers = 'createUsers'; // 新建
    case UpdateUsers = 'updateUsers'; // 编辑
    case DeleteUsers = 'deleteUsers'; // 删除
    case RestoreUsers = 'restoreUsers'; // 恢复删除
    case ForceDeleteUsers = 'forceDeleteUsers'; // 强制删除
    case PermissionAttachAnyUsers = 'attachAnyUsers'; // 赋予用户权限
    case PermissionAttachUsers = 'attachUsers'; // 更新用户权限
    case PermissionDetachUsers = 'detachUsers';    // 取消用户授权

    // 角色
    case Roles = 'roles'; // 分组标示
    case ManagerRoles = 'managerRoles'; // 列表
    case ViewRoles = 'viewRoles'; // 查看
    case CreateRoles = 'createRoles'; // 新建
    case UpdateRoles = 'updateRoles'; // 编辑
    case DeleteRoles = 'deleteRoles'; // 删除
    case RestoreRoles = 'restoreRoles'; // 恢复删除
    case ForceDeleteRoles = 'forceDeleteRoles'; // 强制删除
    case RoleAttachAnyUsers = 'roleAttachAnyUsers'; // 赋予用户角色
    case RoleAttachUsers = 'roleAttachUsers'; // 更新用户角色
    case RoleDetachUsers = 'roleDetachUsers'; // 取消用户角色

    // 权限
    case Permissions = 'permissions'; // 分组标示
    case ManagerPermissions = 'managerPermissions'; // 列表
    case ViewPermissions = 'viewPermissions'; // 查看
    //        case CreatePermissions = 'createPermissions'; // 新建
    //        case UpdatePermissions = 'updatePermissions'; // 编辑
    // case DeletePermissions = 'deletePermissions'; // 删除
    // case RestorePermissions = 'restorePermissions'; // 恢复删除
    // case ForceDeletePermissions = 'forceDeletePermissions'; // 强制删除
    case PermissionAttachAnyRoles = 'permissionAttachAnyRoles'; // 赋予角色权限
    case PermissionAttachRoles = 'permissionAttachRoles'; // 更新角色权限
    case PermissionDetachRoles = 'permissionDetachRoles'; // 取消赋予角色权限

    // 菜单
    case Menus = 'menus'; // 菜单
    case ManagerMenus = 'managerMenus'; // 列表
    case ViewMenus = 'viewMenus'; // 查看
    case CreateMenus = 'createMenus'; // 新建
    case UpdateMenus = 'updateMenus'; // 编辑
    case DeleteMenus = 'deleteMenus'; // 删除

    // 设置
    case Settings = 'settings'; // 设置
    case ViewLogs = 'viewLogs'; // 日志

    public static function count(): int
    {
        return self::availablePermissions()->count();
    }

    /**
     * 所有可用权限
     */
    public static function availablePermissions(): Collection
    {
        return collect(Permission::cases())
            ->reject(fn (self $item) => array_key_exists($item->value, Permission::groups()))
            ->pluck('value');
    }

    public static function groups(): array
    {
        return collect([
            self::Users,
            self::Roles,
            self::Permissions,
            self::Menus,
            self::Settings,
        ])->mapWithKeys(
            fn (self $enum) => [$enum->value => $enum->label()]
        )->toArray();
    }
}
