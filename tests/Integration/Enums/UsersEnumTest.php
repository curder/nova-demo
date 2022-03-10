<?php

use App\Enums\UsersEnum;

it('has groups static method on permissionsEnum class', fn () => expect(UsersEnum::permissions())
    ->toBeCollection()->toHaveCount(1));

it('has enum key value and label method for Super', fn () => expect(UsersEnum::Super)
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('Super', 'super@example.com', '超级管理员'));

it('has enum key value and label method for Example', fn () => expect(UsersEnum::Example)
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('Example', 'example@example.com', '内容管理员'));

