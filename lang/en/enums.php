<?php

use App\Enums;
use App\Enums\Permission;

return [
    Enums\Permission::class => [
        // 用户
        Enums\Permission::Users->value => 'Users',
        Enums\Permission::ManagerUsers->value => 'User List', // 列表
        Enums\Permission::ViewUsers->value => 'View Users', // 查看
        Enums\Permission::CreateUsers->value => 'Create User', // 新建
        Enums\Permission::UpdateUsers->value => 'Update User', // 编辑
        Enums\Permission::DeleteUsers->value => 'Delete User', // 删除
        Enums\Permission::RestoreUsers->value => 'Restore User', // 恢复删除
        Enums\Permission::ForceDeleteUsers->value => 'Force Delete User', // 强制删除
        Enums\Permission::PermissionAttachAnyUsers->value => 'Permission Attach Any User', // 赋予用户授权
        Enums\Permission::PermissionAttachUsers->value => 'Permission Attach User', // 更新用户授权
        Enums\Permission::PermissionDetachUsers->value => 'Permission Detach User', // 取消用户授权

        // 角色
        Enums\Permission::Roles->value => 'Roles',
        Enums\Permission::ManagerRoles->value => 'Role List',
        Enums\Permission::ViewRoles->value => 'View Role',
        Enums\Permission::CreateRoles->value => 'Create Role',
        Enums\Permission::UpdateRoles->value => 'Update Role',
        Enums\Permission::DeleteRoles->value => 'Delete Role',
        Enums\Permission::RestoreRoles->value => 'Restore Role',
        Enums\Permission::ForceDeleteRoles->value => 'Force Delete Role',
        Enums\Permission::RoleAttachAnyUsers->value => 'Role Attach Any User',
        Enums\Permission::RoleAttachUsers->value => 'Role Attach User',
        Enums\Permission::RoleDetachUsers->value => 'Role Detach User',

        // 权限
        Enums\Permission::Permissions->value => 'Permissions',
        Enums\Permission::ManagerPermissions->value => 'Permission List',
        Enums\Permission::ViewPermissions->value => 'View Permission',
        //        Enums\PermissionsEnum::CREATE_PERMISSIONS          ->value => 'Create Permission',
        //        Enums\PermissionsEnum::UPDATE_PERMISSIONS          ->value => 'Update Permission',
        //        Enums\PermissionsEnum::DeletePermissions->value => 'Delete Permission',
        //        Enums\PermissionsEnum::RestorePermissions->value => 'Restore Permission',
        //        Enums\PermissionsEnum::ForceDeletePermissions->value => 'Force Delete Permission1',
        Enums\Permission::PermissionAttachAnyRoles->value => 'Permission Attach Any Role',
        Enums\Permission::PermissionAttachRoles->value => 'Permission Attach Role',
        Enums\Permission::PermissionDetachRoles->value => 'Permission Detach Role',
    ],

    Enums\Role::class => [
        Enums\Role::SuperAdmin->value => 'Super Admin',
        Enums\Role::Content->value => 'Content',
    ],
];
