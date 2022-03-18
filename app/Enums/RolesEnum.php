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
     * @param string $role
     *
     * @return \Illuminate\Support\Collection
     */
    public static function permissions(string $role): Collection
    {
        return collect([
            self::SuperAdmin->value => PermissionsEnum::availablePermissions(),
            self::Content->value => collect([
                Permission::MANAGER_USERS->value,
                Permission::VIEW_USERS->value,
                Permission::UPDATE_USERS->value,
                Permission::DELETE_USERS->value,
                Permission::RESTORE_USERS->value,
            ]),
        ])->get($role, collect([]));
    }
}
