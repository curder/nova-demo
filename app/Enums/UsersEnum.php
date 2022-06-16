<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;

final class UsersEnum extends Enum implements LocalizedEnum
{
    public const SUPER = 'super';
    public const EXAMPLE = 'example';

    public static function permissions(): Collection
    {
        $config = [
            self::SUPER => collect([
                //
            ]),
            self::EXAMPLE => collect([
                PermissionsEnum::CREATE_USERS,
            ]),
        ];

        return collect($config)
            ->mapWithKeys(
                fn ($permission, $key) => [UsersEnum::fromValue($key)->description => $permission]
            )->filter(fn (Collection $permissions) => $permissions->isNotEmpty());
    }

    /**
     * @return int
     */
    public static function count(): int
    {
        return count(self::getInstances());
    }
}
