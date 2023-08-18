<?php

namespace App\Enums;

use App\Traits\Enums\InteractsWithOptions;

enum PermissionEnum: string
{
    use InteractsWithOptions;

    // 用户
    case ManagerUsers = 'managerUsers'; // 列表
    case ViewUsers = 'viewUsers'; // 查看
    case UpdateUsers = 'updateUsers'; // 编辑

    // 菜单
    case ManagerMenus = 'managerMenus'; // 列表
    case ViewMenus = 'viewMenus'; // 查看
    case CreateMenus = 'createMenus'; // 新建
    case UpdateMenus = 'updateMenus'; // 编辑
    case DeleteMenus = 'deleteMenus'; // 删除

    // 设置
    case ViewLogs = 'viewLogs'; // 日志
}
