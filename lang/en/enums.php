<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;

return [
    PermissionsEnum::class => [
        // 用户
        PermissionsEnum::Users->value => 'Users',
        PermissionsEnum::ManagerUsers->value => 'User List', // 列表
        PermissionsEnum::ViewUsers->value => 'View Users', // 查看
        PermissionsEnum::CreateUsers->value => 'Create User', // 新建
        PermissionsEnum::UpdateUsers->value => 'Update User', // 编辑
        PermissionsEnum::DeleteUsers->value => 'Delete User', // 删除
        PermissionsEnum::RestoreUsers->value => 'Restore User', // 恢复删除
        PermissionsEnum::ForceDeleteUsers->value => 'Force Delete User', // 强制删除
        PermissionsEnum::PermissionAttachAnyUsers->value => 'Permission Attach Any User', // 赋予用户授权
        PermissionsEnum::PermissionAttachUsers->value => 'Permission Attach User', // 更新用户授权
        PermissionsEnum::PermissionDetachUsers->value => 'Permission Detach User', // 取消用户授权

        // 角色
        PermissionsEnum::Roles->value => 'Roles',
        PermissionsEnum::ManagerRoles->value => 'Role List',
        PermissionsEnum::ViewRoles->value => 'View Role',
        PermissionsEnum::CreateRoles->value => 'Create Role',
        PermissionsEnum::UpdateRoles->value => 'Update Role',
        PermissionsEnum::DeleteRoles->value => 'Delete Role',
        PermissionsEnum::RestoreRoles->value => 'Restore Role',
        PermissionsEnum::ForceDeleteRoles->value => 'Force Delete Role',
        PermissionsEnum::RoleAttachAnyUsers->value => 'Role Attach Any User',
        PermissionsEnum::RoleAttachUsers->value => 'Role Attach User',
        PermissionsEnum::RoleDetachUsers->value => 'Role Detach User',

        // 权限
        PermissionsEnum::Permissions->value => 'Permissions',
        PermissionsEnum::ManagerPermissions->value => 'Permission List',
        PermissionsEnum::ViewPermissions->value => 'View Permission',
        //        PermissionsEnum::CREATE_PERMISSIONS          ->value => 'Create Permission',
        //        PermissionsEnum::UPDATE_PERMISSIONS          ->value => 'Update Permission',
        //        PermissionsEnum::DeletePermissions->value => 'Delete Permission',
        //        PermissionsEnum::RestorePermissions->value => 'Restore Permission',
        //        PermissionsEnum::ForceDeletePermissions->value => 'Force Delete Permission1',
        PermissionsEnum::PermissionAttachAnyRoles->value => 'Permission Attach Any Role',
        PermissionsEnum::PermissionAttachRoles->value => 'Permission Attach Role',
        PermissionsEnum::PermissionDetachRoles->value => 'Permission Detach Role',
    ],

    RolesEnum::class => [
        RolesEnum::SuperAdmin->value => 'Super Admin',
        RolesEnum::Content->value => 'Content',
    ],
];
