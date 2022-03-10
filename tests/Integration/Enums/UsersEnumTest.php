<?php

use App\Enums\UsersEnum;

it('has groups static method on permissionsEnum class', fn () => expect(UsersEnum::permissions())
    ->toBeCollection()->toHaveCount(1));

it('has some dynamic static method #CURDER', fn () => expect(UsersEnum::CURDER())
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('CURDER', 'curder@example.com', 'Curder'));

it('has some dynamic static method #LINDA()', fn () => expect(UsersEnum::LINDA())
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('LINDA', 'example@example.com', 'Linda'));
