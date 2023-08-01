<?php

namespace App\Enums;

use App\Enums\PermissionsEnum as Permission;
use Illuminate\Support\Collection;

enum PermissionsEnum: string
{
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

    public function label(): string
    {
        return match ($this) {
            // Users
            self::Users => self::labelFromTranslate(self::Users),
            self::ManagerUsers => self::labelFromTranslate(self::ManagerUsers),
            self::ViewUsers => self::labelFromTranslate(self::ViewUsers),
            self::CreateUsers => self::labelFromTranslate(self::CreateUsers),
            self::UpdateUsers => self::labelFromTranslate(self::UpdateUsers),
            self::DeleteUsers => self::labelFromTranslate(self::DeleteUsers),
            self::RestoreUsers => self::labelFromTranslate(self::RestoreUsers),
            self::ForceDeleteUsers => self::labelFromTranslate(self::ForceDeleteUsers),
            self::PermissionAttachAnyUsers => self::labelFromTranslate(self::PermissionAttachAnyUsers),
            self::PermissionAttachUsers => self::labelFromTranslate(self::PermissionAttachUsers),
            self::PermissionDetachUsers => self::labelFromTranslate(self::PermissionDetachUsers),

            // Roles
            self::Roles => self::labelFromTranslate(self::Roles),
            self::ManagerRoles => self::labelFromTranslate(self::ManagerRoles),
            self::ViewRoles => self::labelFromTranslate(self::ViewRoles),
            self::CreateRoles => self::labelFromTranslate(self::CreateRoles),
            self::UpdateRoles => self::labelFromTranslate(self::UpdateRoles),
            self::DeleteRoles => self::labelFromTranslate(self::DeleteRoles),
            self::RestoreRoles => self::labelFromTranslate(self::RestoreRoles),
            self::ForceDeleteRoles => self::labelFromTranslate(self::ForceDeleteRoles),
            self::RoleAttachAnyUsers => self::labelFromTranslate(self::RoleAttachAnyUsers),
            self::RoleAttachUsers => self::labelFromTranslate(self::RoleAttachUsers),
            self::RoleDetachUsers => self::labelFromTranslate(self::RoleDetachUsers),

            // Permissions
            self::Permissions => self::labelFromTranslate(self::Permissions),
            self::ManagerPermissions => self::labelFromTranslate(self::ManagerPermissions),
            self::ViewPermissions => self::labelFromTranslate(self::ViewPermissions),
            self::PermissionAttachAnyRoles => self::labelFromTranslate(self::PermissionAttachAnyRoles),
            self::PermissionAttachRoles => self::labelFromTranslate(self::PermissionAttachRoles),
            self::PermissionDetachRoles => self::labelFromTranslate(self::PermissionDetachRoles),

            // Menus
            self::Menus => self::labelFromTranslate(self::Menus),
            self::ManagerMenus => self::labelFromTranslate(self::ManagerMenus),
            self::ViewMenus => self::labelFromTranslate(self::ViewMenus),
            self::CreateMenus => self::labelFromTranslate(self::CreateMenus),
            self::UpdateMenus => self::labelFromTranslate(self::UpdateMenus),
            self::DeleteMenus => self::labelFromTranslate(self::DeleteMenus),

            // Settings
            self::Settings => self::labelFromTranslate(self::Settings),
            self::ViewLogs => self::labelFromTranslate(self::ViewLogs),
        };
    }

    protected static function labelFromTranslate(self $enum): string
    {
        return trans('enums.'.PermissionsEnum::class.'.'.$enum->value);
    }

    /**
     * 所有可用权限
     */
    public static function availablePermissions(): Collection
    {
        return collect(Permission::cases())
            ->reject(fn (Permission $item) => array_key_exists($item->value, Permission::groups()))
            ->pluck('value');
    }

    public static function groups(): array
    {
        return [
            self::Users->value => self::Users->label(),
            self::Roles->value => self::Roles->label(),
            self::Permissions->value => self::Permissions->label(),
            self::Menus->value => self::Menus->label(),
            self::Settings->value => self::Settings->label(),
        ];
    }

    public static function count(): int
    {
        return self::availablePermissions()->count();
    }
}
