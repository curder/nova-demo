<?php

use App\Enums\UsersEnum;

it('has groups static method on permissionsEnum class', fn () => expect(UsersEnum::permissions())
    ->toBeCollection()->toHaveCount(1));

it('has enum key value and label method for Curder', fn () => expect(UsersEnum::Super)
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('Admin', 'admin@example.com', '超级管理员'));

it('has enum key value and label method for Mkt', fn () => expect(UsersEnum::Example)
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('Example', 'example@example.com', '内容管理员'));
