<?php

namespace App\Enums;

use App\Enums;
use App\Traits\Enums\InteractsWithOptions;
use Illuminate\Support\Collection;

enum Role: string
{
    use InteractsWithOptions;

    case SuperAdmin = 'Super Admin'; // 超级管理员
    case Content = 'Content'; // 内容管理员

    public function users(): Collection
    {
        return match ($this) {
            self::SuperAdmin => collect([
                Enums\User::Super,
            ]),
            self::Content => collect([
                Enums\User::Example,
            ]),
            default => collect([]),
        };
    }

    public static function count(): int
    {
        return count(self::cases());
    }

    /**
     * 角色对应的权限关联关系
     */
    public static function permissions(string $role): Collection
    {
        return collect([
            self::SuperAdmin->value => Enums\Permission::availablePermissions(),
            self::Content->value => collect([
                Enums\Permission::ManagerUsers->value,
                Enums\Permission::ViewUsers->value,
                Enums\Permission::UpdateUsers->value,
                Enums\Permission::DeleteUsers->value,
                Enums\Permission::RestoreUsers->value,

                Enums\Permission::ManagerMenus->value,
                Enums\Permission::ViewMenus->value,
            ]),
        ])->get($role, collect([]));
    }
}
