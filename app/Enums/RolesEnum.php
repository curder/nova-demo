<?php

namespace App\Enums;

use App\Enums\PermissionsEnum as Permission;
use Illuminate\Support\Collection;

enum RolesEnum: string
{
    case SuperAdmin = 'Super Admin'; // 超级管理员
    case Content = 'Content'; // 内容管理员

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => self::labelFromTranslate(self::SuperAdmin),
            self::Content => self::labelFromTranslate(self::Content),
        };
    }

    protected static function labelFromTranslate(self $enum): string
    {
        return __('enums.'.RolesEnum::class.'.'.$enum->value);
    }

    public function users(): Collection
    {
        return match ($this) {
            self::SuperAdmin => collect([
                UsersEnum::Super,
            ]),
            self::Content => collect([
                UsersEnum::Example,
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
            self::SuperAdmin->value => PermissionsEnum::availablePermissions(),
            self::Content->value => collect([
                Permission::ManagerUsers->value,
                Permission::ViewUsers->value,
                Permission::UpdateUsers->value,
                Permission::DeleteUsers->value,
                Permission::RestoreUsers->value,

                Permission::ManagerMenus->value,
                Permission::ViewMenus->value,
            ]),
        ])->get($role, collect([]));
    }
}
