<?php

namespace App\Enums;

use App\Enums\PermissionsEnum as Permission;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

final class RolesEnum extends Enum implements LocalizedEnum
{
    public const  SUPER_ADMIN = 'superAdmin'; // 超级管理员
    public const  CONTENT = 'content'; // 内容管理员


//    public function label(): string
//    {
//        return match ($this) {
//            self::SUPER_ADMIN => '超级管理员',
//            self::CONTENT => '内容管理员',
//        };
//    }

    public function users(): Collection
    {
        return match ($this->value) {
            self::SUPER_ADMIN => collect([
                UsersEnum::fromValue(UsersEnum::SUPER)->description,
            ]),
            self::CONTENT => collect([
                UsersEnum::fromValue(UsersEnum::EXAMPLE)->description,
            ]),
            default => collect([]),
        };
    }

    /**
     * @return int
     */
    public static function count(): int
    {
        return count(self::getConstants());
    }

    /**
     * 角色对应的权限关联关系
     *
     * @param string $role
     *
     * @return \Illuminate\Support\Collection
     */
    public static function permissions(string $role): Collection
    {
        return collect([
            self::SUPER_ADMIN => PermissionsEnum::availablePermissions(),
            self::CONTENT => collect([
                Permission::MANAGER_USERS,
                Permission::VIEW_USERS,
                Permission::UPDATE_USERS,
                Permission::DELETE_USERS,
                Permission::RESTORE_USERS,

                Permission::MANAGER_MENUS,
                Permission::VIEW_MENUS,
            ]),
        ])->get($role, collect([]));
    }
}
