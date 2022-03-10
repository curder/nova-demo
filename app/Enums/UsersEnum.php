<?php

namespace App\Enums;

use App\Enums\PermissionsEnum;
use Illuminate\Support\Collection;

enum UsersEnum: string
{
    case Super = 'super@example.com';
    case Example = 'example@example.com';

    public function label(): string
    {
        return match($this) {
            self::Super => '超级管理员',
            self::Example => '内容管理员',
        };
    }


    public static function permissions(): Collection
    {
        $config = [
            self::Super->value => [
                //
            ],
            self::Example->value => [
                PermissionsEnum::CREATE_USERS,
            ],
        ];

        return collect($config)->filter();
    }

}
