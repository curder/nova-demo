<?php

use App\Enums;

return [
    Enums\PermissionEnum::class => [
        // 用户
        Enums\PermissionEnum::Users->value => '用户',
        Enums\PermissionEnum::ManagerUsers->value => '用户列表', // 列表
        Enums\PermissionEnum::ViewUsers->value => '查看用户', // 查看
        Enums\PermissionEnum::CreateUsers->value => '新建用户', // 新建
        Enums\PermissionEnum::UpdateUsers->value => '编辑用户', // 编辑
        Enums\PermissionEnum::DeleteUsers->value => '删除用户', // 删除
        Enums\PermissionEnum::RestoreUsers->value => '恢复删除用户', // 恢复删除
        Enums\PermissionEnum::ForceDeleteUsers->value => '强制删除用户', // 强制删除
        Enums\PermissionEnum::PermissionAttachAnyUsers->value => '赋予用户权限', // 赋予用户授权
        Enums\PermissionEnum::PermissionAttachUsers->value => '更新用户授权', // 更新用户授权
        Enums\PermissionEnum::PermissionDetachUsers->value => '取消用户授权', // 取消用户授权

        // 角色
        Enums\PermissionEnum::Roles->value => '角色',
        Enums\PermissionEnum::ManagerRoles->value => '角色列表',
        Enums\PermissionEnum::ViewRoles->value => '查看角色',
        Enums\PermissionEnum::CreateRoles->value => '新建角色',
        Enums\PermissionEnum::UpdateRoles->value => '编辑角色',
        Enums\PermissionEnum::DeleteRoles->value => '删除角色',
        Enums\PermissionEnum::RestoreRoles->value => '恢复删除角色',
        Enums\PermissionEnum::ForceDeleteRoles->value => '强制删除角色',
        Enums\PermissionEnum::RoleAttachAnyUsers->value => '赋予用户角色',
        Enums\PermissionEnum::RoleAttachUsers->value => '更新用户角色',
        Enums\PermissionEnum::RoleDetachUsers->value => '取消用户角色',

        // 权限
        Enums\PermissionEnum::Permissions->value => '权限',
        Enums\PermissionEnum::ManagerPermissions->value => '权限列表',
        Enums\PermissionEnum::ViewPermissions->value => '查看权限',
        //        Enums\PermissionsEnum::CREATE_PERMISSIONS->value           => '新建权限',
        //        Enums\PermissionsEnum::UPDATE_PERMISSIONS->value           => '编辑权限',
        //        Enums\PermissionsEnum::DeletePermissions->value => '删除权限',
        //        Enums\PermissionsEnum::RestorePermissions->value => '恢复删除权限',
        //        Enums\PermissionsEnum::ForceDeletePermissions->value => '强制删除权限',
        Enums\PermissionEnum::PermissionAttachAnyRoles->value => '赋予角色权限',
        Enums\PermissionEnum::PermissionAttachRoles->value => '更新角色权限',
        Enums\PermissionEnum::PermissionDetachRoles->value => '取消角色权限',

        // 菜单
        Enums\PermissionEnum::Menus->value => '菜单',
        Enums\PermissionEnum::ManagerMenus->value => '菜单管理',
        Enums\PermissionEnum::ViewMenus->value => '查看菜单',
        Enums\PermissionEnum::CreateMenus->value => '创建菜单',
        Enums\PermissionEnum::UpdateMenus->value => '更新菜单',
        Enums\PermissionEnum::DeleteMenus->value => '删除菜单',

        // 设置
        Enums\PermissionEnum::Settings->value => '设置',
        Enums\PermissionEnum::ViewLogs->value => '系统日志',
    ],

    Enums\RoleEnum::class => [
        Enums\RoleEnum::SuperAdmin->value => '超级管理员',
        Enums\RoleEnum::Content->value => '编辑员',
    ],
];
