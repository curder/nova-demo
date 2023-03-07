<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;

return [
    PermissionsEnum::class => [
        // 用户
        PermissionsEnum::USERS                       => 'Users',
        PermissionsEnum::MANAGER_USERS               => 'User List', // 列表
        PermissionsEnum::VIEW_USERS                  => 'View Users', // 查看
        PermissionsEnum::CREATE_USERS                => 'Create User', // 新建
        PermissionsEnum::UPDATE_USERS                => 'Update User', // 编辑
        PermissionsEnum::DELETE_USERS                => 'Delete User', // 删除
        PermissionsEnum::RESTORE_USERS               => 'Restore User', // 恢复删除
        PermissionsEnum::FORCE_DELETE_USERS          => 'Force Delete User', // 强制删除
        PermissionsEnum::PERMISSION_ATTACH_ANY_USERS => 'Permission Attach Any User', // 赋予用户授权
        PermissionsEnum::PERMISSION_ATTACH_USERS => 'Permission Attach User', // 更新用户授权
        PermissionsEnum::PERMISSION_DETACH_USERS => 'Permission Detach User', // 取消用户授权

        // 角色
        PermissionsEnum::ROLES                  => 'Roles',
        PermissionsEnum::MANAGER_ROLES            => 'Role List',
        PermissionsEnum::VIEW_ROLES               => 'View Role',
        PermissionsEnum::CREATE_ROLES             => 'Create Role',
        PermissionsEnum::UPDATE_ROLES             => 'Update Role',
        PermissionsEnum::DELETE_ROLES             => 'Delete Role',
        PermissionsEnum::RESTORE_ROLES             => 'Restore Role',
        PermissionsEnum::FORCE_DELETE_ROLES        => 'Force Delete Role',
        PermissionsEnum::ROLE_ATTACH_ANY_USERS     => 'Role Attach Any User',
        PermissionsEnum::ROLE_ATTACH_USERS         => 'Role Attach User',
        PermissionsEnum::ROLE_DETACH_USERS         => 'Role Detach User',

        // 权限
        PermissionsEnum::PERMISSIONS                 => 'Permissions',
        PermissionsEnum::MANAGER_PERMISSIONS         => 'Permission List',
        PermissionsEnum::VIEW_PERMISSIONS            => 'View Permission',
//        PermissionsEnum::CREATE_PERMISSIONS           => 'Create Permission',
//        PermissionsEnum::UPDATE_PERMISSIONS           => 'Update Permission',
        PermissionsEnum::DELETE_PERMISSIONS           => 'Delete Permission',
        PermissionsEnum::RESTORE_PERMISSIONS          => 'Restore Permission',
        PermissionsEnum::FORCE_DELETE_PERMISSIONS     => 'Force Delete Permission1',
        PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES  => 'Permission Attach Any Role',
        PermissionsEnum::PERMISSION_ATTACH_ROLES      => 'Permission Attach Role',
        PermissionsEnum::PERMISSION_DETACH_ROLES      => 'Permission Detach Role',
    ],

    RolesEnum::class => [
        RolesEnum::SUPER_ADMIN => 'Super Admin',
        RolesEnum::CONTENT => 'Editor',
    ],
];
