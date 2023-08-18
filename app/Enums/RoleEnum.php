<?php

namespace App\Enums;

use App\Enums;
use App\Traits\Enums\InteractsWithOptions;

enum RoleEnum: string
{
    use InteractsWithOptions;

    case SuperAdmin = 'Super Admin'; // 超级管理员
    case Content = 'Content'; // 内容管理员

    /**
     * 角色对应的权限关联关系
     */
    public function permissions(): array
    {
        return match ($this) {
            self::SuperAdmin => Enums\PermissionEnum::cases(),
            self::Content => [
                Enums\PermissionEnum::ManagerUsers,
                Enums\PermissionEnum::ViewUsers,
                Enums\PermissionEnum::UpdateUsers,

                Enums\PermissionEnum::ManagerMenus,
                Enums\PermissionEnum::ViewMenus,
            ]
        };
    }
}
