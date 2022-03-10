<?php

namespace App\Enums;

use App\Enums\PermissionsEnum as Permission;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

/**
 * @method static self SUPER_ADMIN()
 * @method static self CONTENT()
 */
class RolesEnum extends Enum implements LocalizedEnum
{
    public const SUPER_ADMIN = 'superAdmin'; // 超级管理员
    public const CONTENT = 'content'; // 内容管理员

    public static function users($role)
    {
        return collect([
            self::SUPER_ADMIN => collect([
                UsersEnum::SUPER,
            ]),
            self::CONTENT => collect([
                UsersEnum::EXAMPLE,
            ]),
        ])->get($role, collect([]));
    }

    /**
     * @return int
     */
    public static function count(): int
    {
        return count(self::getInstances());
    }

    /**
     * @param $role
     *
     * @return \Illuminate\Support\Collection
     */
    public static function permissions($role): Collection
    {
        return collect([
            self::SUPER_ADMIN => PermissionsEnum::availablePermissions(),
            self::CONTENT => collect([
                Permission::MANAGER_USERS,
                Permission::VIEW_USERS,
                Permission::UPDATE_USERS,
                Permission::DELETE_USERS,
                Permission::RESTORE_USERS,
            ]),
        ])->get($role, collect([]));
    }
}
