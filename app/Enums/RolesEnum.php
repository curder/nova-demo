<?php

namespace App\Enums;

use App\Enums\PermissionsEnum as Permission;
use Illuminate\Support\Collection;

enum RolesEnum: string
{
    case SuperAdmin = 'superAdmin'; // 超级管理员
    case Content = 'content'; // 内容管理员

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => '超级管理员',
            self::Content => '内容管理员',
        };
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

    /**
     * @return int
     */
    public static function count(): int
    {
        return count(self::cases());
    }

    /**
     * @param $role
     *
     * @return \Illuminate\Support\Collection
     */
    public static function permissions($role): Collection
    {
        return collect([
            self::SuperAdmin->value => PermissionsEnum::availablePermissions(),
            self::Content->value => collect([
                Permission::MANAGER_USERS,
                Permission::VIEW_USERS,
                Permission::UPDATE_USERS,
                Permission::DELETE_USERS,
                Permission::RESTORE_USERS,
            ]),
        ])->get($role, collect([]));
    }
}
