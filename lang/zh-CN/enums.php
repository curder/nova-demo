<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;

return [
    PermissionsEnum::class => [
        // 用户
        PermissionsEnum::Users->value => '用户',
        PermissionsEnum::ManagerUsers->value => '用户列表', // 列表
        PermissionsEnum::ViewUsers->value => '查看用户', // 查看
        PermissionsEnum::CreateUsers->value => '新建用户', // 新建
        PermissionsEnum::UpdateUsers->value => '编辑用户', // 编辑
        PermissionsEnum::DeleteUsers->value => '删除用户', // 删除
        PermissionsEnum::RestoreUsers->value => '恢复删除用户', // 恢复删除
        PermissionsEnum::ForceDeleteUsers->value => '强制删除用户', // 强制删除
        PermissionsEnum::PermissionAttachAnyUsers->value => '赋予用户权限', // 赋予用户授权
        PermissionsEnum::PermissionAttachUsers->value => '更新用户授权', // 更新用户授权
        PermissionsEnum::PermissionDetachUsers->value => '取消用户授权', // 取消用户授权

        // 角色
        PermissionsEnum::Roles->value => '角色',
        PermissionsEnum::ManagerRoles->value => '角色列表',
        PermissionsEnum::ViewRoles->value => '查看角色',
        PermissionsEnum::CreateRoles->value => '新建角色',
        PermissionsEnum::UpdateRoles->value => '编辑角色',
        PermissionsEnum::DeleteRoles->value => '删除角色',
        PermissionsEnum::RestoreRoles->value => '恢复删除角色',
        PermissionsEnum::ForceDeleteRoles->value => '强制删除角色',
        PermissionsEnum::RoleAttachAnyUsers->value => '赋予用户角色',
        PermissionsEnum::RoleAttachUsers->value => '更新用户角色',
        PermissionsEnum::RoleDetachUsers->value => '取消用户角色',

        // 权限
        PermissionsEnum::Permissions->value => '权限',
        PermissionsEnum::ManagerPermissions->value => '权限列表',
        PermissionsEnum::ViewPermissions->value => '查看权限',
        //        PermissionsEnum::CREATE_PERMISSIONS->value           => '新建权限',
        //        PermissionsEnum::UPDATE_PERMISSIONS->value           => '编辑权限',
        //        PermissionsEnum::DeletePermissions->value => '删除权限',
        //        PermissionsEnum::RestorePermissions->value => '恢复删除权限',
        //        PermissionsEnum::ForceDeletePermissions->value => '强制删除权限',
        PermissionsEnum::PermissionAttachAnyRoles->value => '赋予角色权限',
        PermissionsEnum::PermissionAttachRoles->value => '更新角色权限',
        PermissionsEnum::PermissionDetachRoles->value => '取消角色权限',

        // 菜单
        PermissionsEnum::Menus->value => '菜单',
        PermissionsEnum::ManagerMenus->value => '菜单管理',
        PermissionsEnum::ViewMenus->value => '查看菜单',
        PermissionsEnum::CreateMenus->value => '创建菜单',
        PermissionsEnum::UpdateMenus->value => '更新菜单',
        PermissionsEnum::DeleteMenus->value => '删除菜单',

        // 设置
        PermissionsEnum::Settings->value => '设置',
        PermissionsEnum::ViewLogs->value => '系统日志',
    ],

    RolesEnum::class => [
        RolesEnum::SuperAdmin->value => '超级管理员',
        RolesEnum::Content->value => '编辑员',
    ],
];
