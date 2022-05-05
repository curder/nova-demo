<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum UsersEnum: string
{
    case Super = 'super@example.com';
    case Example = 'example@example.com';

    public function label(): string
    {
        return match ($this) {
            self::Super => '超级管理员',
            self::Example => '内容管理员',
        };
    }

    public static function permissions(): Collection
    {
        $config = [
            self::Super->value => collect([
                //
            ]),
            self::Example->value => collect([
                PermissionsEnum::CREATE_USERS->value,
            ]),
        ];

        return collect($config)->filter(fn (Collection $permissions) => $permissions->isNotEmpty());
    }

    /**
     * @return int
     */
    public static function count(): int
    {
        return count(self::cases());
    }
}
