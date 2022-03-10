<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

final class UsersEnum extends Enum
{
    public const CURDER = 'curder@example.com';

    public const LINDA = 'example@example.com';

    /**
     * 用户额外的权限
     *
     * @return Collection
     */
    public static function permissions(): Collection
    {
        $config = [
            self::CURDER => [
                //
            ],
            self::LINDA => [
                PermissionsEnum::CREATE_USERS,
            ],
        ];

        return collect($config)->filter();
    }
}
