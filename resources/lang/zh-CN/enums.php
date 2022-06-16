<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Enums\UsersEnum;

return [
    PermissionsEnum::class => [
        // 用户
        PermissionsEnum::USERS                       => '用户',
        PermissionsEnum::MANAGER_USERS               => '列表', // 列表
        PermissionsEnum::VIEW_USERS                  => '查看', // 查看
        PermissionsEnum::CREATE_USERS                => '新建', // 新建
        PermissionsEnum::UPDATE_USERS                => '编辑', // 编辑
        PermissionsEnum::DELETE_USERS                => '删除', // 删除
        PermissionsEnum::RESTORE_USERS               => '恢复删除', // 恢复删除
        PermissionsEnum::FORCE_DELETE_USERS          => '强制删除', // 强制删除
        PermissionsEnum::PERMISSION_ATTACH_ANY_USERS => '赋予用户权限', // 赋予用户授权
        PermissionsEnum::PERMISSION_ATTACH_USERS => '更新用户授权', // 更新用户授权
        PermissionsEnum::PERMISSION_DETACH_USERS => '取消用户授权', // 取消用户授权

        // 角色
        PermissionsEnum::ROLES                  => '角色',
        PermissionsEnum::MANAGER_ROLES            => '列表',
        PermissionsEnum::VIEW_ROLES               => '查看',
        PermissionsEnum::CREATE_ROLES             => '新建',
        PermissionsEnum::UPDATE_ROLES             => '编辑',
        PermissionsEnum::DELETE_ROLES             => '删除',
        PermissionsEnum::RESTORE_ROLES             => '恢复删除',
        PermissionsEnum::FORCE_DELETE_ROLES        => '强制删除',
        PermissionsEnum::ROLE_ATTACH_ANY_USERS     => '赋予用户角色',
        PermissionsEnum::ROLE_ATTACH_USERS         => '更新用户角色',
        PermissionsEnum::ROLE_DETACH_USERS         => '取消用户角色',

        // 权限
        PermissionsEnum::PERMISSIONS                 => '权限',
        PermissionsEnum::MANAGER_PERMISSIONS         => '列表',
        PermissionsEnum::VIEW_PERMISSIONS            => '查看',
//        PermissionsEnum::CREATE_PERMISSIONS           => '新建',
//        PermissionsEnum::UPDATE_PERMISSIONS           => '编辑',
        PermissionsEnum::DELETE_PERMISSIONS           => '删除',
        PermissionsEnum::RESTORE_PERMISSIONS          => '恢复删除',
        PermissionsEnum::FORCE_DELETE_PERMISSIONS     => '强制删除',
        PermissionsEnum::PERMISSION_ATTACH_ANY_ROLES  => '赋予角色权限',
        PermissionsEnum::PERMISSION_ATTACH_ROLES      => '更新角色权限',
        PermissionsEnum::PERMISSION_DETACH_ROLES      => '取消角色权限',

        // 菜单
        PermissionsEnum::MENUS => '菜单',
        PermissionsEnum::MANAGER_MENUS => '列表',
        PermissionsEnum::VIEW_MENUS => '查看',
        PermissionsEnum::CREATE_MENUS => '新建',
        PermissionsEnum::UPDATE_MENUS => '编辑',
        PermissionsEnum::DELETE_MENUS => '删除',
    ],

    RolesEnum::class => [
        RolesEnum::SUPER_ADMIN => '超级管理员',
        RolesEnum::CONTENT => '编辑管理员',
    ],

    UsersEnum::class => [
        UsersEnum::SUPER => 'super@example.com',
        UsersEnum::EXAMPLE => 'example@example.com',
    ],

];
