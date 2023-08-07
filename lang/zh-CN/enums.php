<?php

use App\Enums;

return [
    Enums\Permission::class => [
        // 用户
        Enums\Permission::Users->value => '用户',
        Enums\Permission::ManagerUsers->value => '用户列表', // 列表
        Enums\Permission::ViewUsers->value => '查看用户', // 查看
        Enums\Permission::CreateUsers->value => '新建用户', // 新建
        Enums\Permission::UpdateUsers->value => '编辑用户', // 编辑
        Enums\Permission::DeleteUsers->value => '删除用户', // 删除
        Enums\Permission::RestoreUsers->value => '恢复删除用户', // 恢复删除
        Enums\Permission::ForceDeleteUsers->value => '强制删除用户', // 强制删除
        Enums\Permission::PermissionAttachAnyUsers->value => '赋予用户权限', // 赋予用户授权
        Enums\Permission::PermissionAttachUsers->value => '更新用户授权', // 更新用户授权
        Enums\Permission::PermissionDetachUsers->value => '取消用户授权', // 取消用户授权

        // 角色
        Enums\Permission::Roles->value => '角色',
        Enums\Permission::ManagerRoles->value => '角色列表',
        Enums\Permission::ViewRoles->value => '查看角色',
        Enums\Permission::CreateRoles->value => '新建角色',
        Enums\Permission::UpdateRoles->value => '编辑角色',
        Enums\Permission::DeleteRoles->value => '删除角色',
        Enums\Permission::RestoreRoles->value => '恢复删除角色',
        Enums\Permission::ForceDeleteRoles->value => '强制删除角色',
        Enums\Permission::RoleAttachAnyUsers->value => '赋予用户角色',
        Enums\Permission::RoleAttachUsers->value => '更新用户角色',
        Enums\Permission::RoleDetachUsers->value => '取消用户角色',

        // 权限
        Enums\Permission::Permissions->value => '权限',
        Enums\Permission::ManagerPermissions->value => '权限列表',
        Enums\Permission::ViewPermissions->value => '查看权限',
        //        Enums\PermissionsEnum::CREATE_PERMISSIONS->value           => '新建权限',
        //        Enums\PermissionsEnum::UPDATE_PERMISSIONS->value           => '编辑权限',
        //        Enums\PermissionsEnum::DeletePermissions->value => '删除权限',
        //        Enums\PermissionsEnum::RestorePermissions->value => '恢复删除权限',
        //        Enums\PermissionsEnum::ForceDeletePermissions->value => '强制删除权限',
        Enums\Permission::PermissionAttachAnyRoles->value => '赋予角色权限',
        Enums\Permission::PermissionAttachRoles->value => '更新角色权限',
        Enums\Permission::PermissionDetachRoles->value => '取消角色权限',

        // 菜单
        Enums\Permission::Menus->value => '菜单',
        Enums\Permission::ManagerMenus->value => '菜单管理',
        Enums\Permission::ViewMenus->value => '查看菜单',
        Enums\Permission::CreateMenus->value => '创建菜单',
        Enums\Permission::UpdateMenus->value => '更新菜单',
        Enums\Permission::DeleteMenus->value => '删除菜单',

        // 设置
        Enums\Permission::Settings->value => '设置',
        Enums\Permission::ViewLogs->value => '系统日志',
    ],

    Enums\Role::class => [
        Enums\Role::SuperAdmin->value => '超级管理员',
        Enums\Role::Content->value => '编辑员',
    ],
];
