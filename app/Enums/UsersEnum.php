<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

/**
 * @method static self SUPER()
 * @method static self EXAMPLE()
 */
final class UsersEnum extends Enum
{
    public const SUPER = 'super@example.com';

    public const EXAMPLE = 'example@example.com';

    /**
     * 用户额外的权限
     *
     * @return Collection
     */
    public static function permissions(): Collection
    {
        $config = [
            self::SUPER => [
                //
            ],
            self::EXAMPLE => [
                PermissionsEnum::CREATE_USERS,
            ],
        ];

        return collect($config)->filter();
    }
}
