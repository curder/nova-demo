<?php

use App\Enums\PermissionsEnum;

return [
    PermissionEnum::class => [
        // 用户
        PermissionEnum::USERS                       => '用户',
        PermissionEnum::MANAGER_USERS               => '列表', // 列表
        PermissionEnum::VIEW_USERS                  => '查看', // 查看
        PermissionEnum::CREATE_USERS                => '新建', // 新建
        PermissionEnum::UPDATE_USERS                => '编辑', // 编辑
        PermissionEnum::DELETE_USERS                => '删除', // 删除
        PermissionEnum::RESTORE_USERS               => '恢复删除', // 恢复删除
        PermissionEnum::FORCE_DELETE_USERS          => '强制删除', // 强制删除
        PermissionEnum::PERMISSION_ATTACH_ANY_USERS => '赋予用户权限', // 赋予用户授权
        PermissionEnum::PERMISSION_ATTACH_USERS => '更新用户授权', // 更新用户授权
        PermissionEnum::PERMISSION_DETACH_USERS => '取消用户授权', // 取消用户授权

        // 角色
        PermissionEnum::ROLES                  => '角色',
        PermissionEnum::MANAGER_ROLES            => '列表',
        PermissionEnum::VIEW_ROLES               => '查看',
        PermissionEnum::CREATE_ROLES             => '新建',
        PermissionEnum::UPDATE_ROLES             => '编辑',
        PermissionEnum::DELETE_ROLES             => '删除',
        PermissionEnum::RESTORE_ROLES             => '恢复删除',
        PermissionEnum::FORCE_DELETE_ROLES        => '强制删除',
        PermissionEnum::ROLE_ATTACH_ANY_USERS     => '赋予用户角色',
        PermissionEnum::ROLE_ATTACH_USERS         => '更新用户角色',
        PermissionEnum::ROLE_DETACH_USERS         => '取消用户角色',

        // 权限
        PermissionEnum::PERMISSIONS                 => '权限',
        PermissionEnum::MANAGER_PERMISSIONS         => '列表',
        PermissionEnum::VIEW_PERMISSIONS            => '查看',
        PermissionEnum::CREATE_PERMISSIONS           => '新建',
        PermissionEnum::UPDATE_PERMISSIONS           => '编辑',
        PermissionEnum::DELETE_PERMISSIONS           => '删除',
        PermissionEnum::RESTORE_PERMISSIONS          => '恢复删除',
        PermissionEnum::FORCE_DELETE_PERMISSIONS     => '强制删除',
        PermissionEnum::PERMISSION_ATTACH_ANY_ROLES  => '赋予角色权限',
        PermissionEnum::PERMISSION_ATTACH_ROLES      => '更新角色权限',
        PermissionEnum::PERMISSION_DETACH_ROLES      => '取消角色权限',
    ]
];
