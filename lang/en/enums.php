<?php

use App\Enums;

return [
    Enums\PermissionEnum::class => [
        // 用户
        Enums\PermissionEnum::Users->value => 'Users',
        Enums\PermissionEnum::ManagerUsers->value => 'User List', // 列表
        Enums\PermissionEnum::ViewUsers->value => 'View Users', // 查看
        Enums\PermissionEnum::CreateUsers->value => 'Create User', // 新建
        Enums\PermissionEnum::UpdateUsers->value => 'Update User', // 编辑
        Enums\PermissionEnum::DeleteUsers->value => 'Delete User', // 删除
        Enums\PermissionEnum::RestoreUsers->value => 'Restore User', // 恢复删除
        Enums\PermissionEnum::ForceDeleteUsers->value => 'Force Delete User', // 强制删除
        Enums\PermissionEnum::PermissionAttachAnyUsers->value => 'Permission Attach Any User', // 赋予用户授权
        Enums\PermissionEnum::PermissionAttachUsers->value => 'Permission Attach User', // 更新用户授权
        Enums\PermissionEnum::PermissionDetachUsers->value => 'Permission Detach User', // 取消用户授权

        // 角色
        Enums\PermissionEnum::Roles->value => 'Roles',
        Enums\PermissionEnum::ManagerRoles->value => 'Role List',
        Enums\PermissionEnum::ViewRoles->value => 'View Role',
        Enums\PermissionEnum::CreateRoles->value => 'Create Role',
        Enums\PermissionEnum::UpdateRoles->value => 'Update Role',
        Enums\PermissionEnum::DeleteRoles->value => 'Delete Role',
        Enums\PermissionEnum::RestoreRoles->value => 'Restore Role',
        Enums\PermissionEnum::ForceDeleteRoles->value => 'Force Delete Role',
        Enums\PermissionEnum::RoleAttachAnyUsers->value => 'Role Attach Any User',
        Enums\PermissionEnum::RoleAttachUsers->value => 'Role Attach User',
        Enums\PermissionEnum::RoleDetachUsers->value => 'Role Detach User',

        // 权限
        Enums\PermissionEnum::Permissions->value => 'Permissions',
        Enums\PermissionEnum::ManagerPermissions->value => 'Permission List',
        Enums\PermissionEnum::ViewPermissions->value => 'View Permission',
        //        Enums\PermissionsEnum::CREATE_PERMISSIONS          ->value => 'Create Permission',
        //        Enums\PermissionsEnum::UPDATE_PERMISSIONS          ->value => 'Update Permission',
        //        Enums\PermissionsEnum::DeletePermissions->value => 'Delete Permission',
        //        Enums\PermissionsEnum::RestorePermissions->value => 'Restore Permission',
        //        Enums\PermissionsEnum::ForceDeletePermissions->value => 'Force Delete Permission1',
        Enums\PermissionEnum::PermissionAttachAnyRoles->value => 'Permission Attach Any Role',
        Enums\PermissionEnum::PermissionAttachRoles->value => 'Permission Attach Role',
        Enums\PermissionEnum::PermissionDetachRoles->value => 'Permission Detach Role',
    ],

    Enums\RoleEnum::class => [
        Enums\RoleEnum::SuperAdmin->value => 'Super Admin',
        Enums\RoleEnum::Content->value => 'Content',
    ],
];
