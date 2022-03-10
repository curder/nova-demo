<?php

use App\Enums\UsersEnum;

it('has groups static method on permissionsEnum class', fn () => expect(UsersEnum::permissions())
    ->toBeCollection()->toHaveCount(1));

it('has some dynamic static method #CURDER', fn () => expect(UsersEnum::SUPER())
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('SUPER', 'super@example.com', 'Super'));

it('has some dynamic static method #EXAMPLE()', fn () => expect(UsersEnum::EXAMPLE())
    ->toBeInstanceOf(UsersEnum::class)
    ->toBeEnum('EXAMPLE', 'example@example.com', 'Example'));
