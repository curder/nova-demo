<?php

use App\Enums\UsersEnum;

it('has groups static method on UsersEnum class', fn () => expect(UsersEnum::permissions())
    ->toBeCollection()->toHaveCount(1));

it('has some items in UsersEnum class', function (string $value) {
    expect(UsersEnum::fromValue($value))
        ->toBeInstanceOf(UsersEnum::class)
        ->key->toEqual(UsersEnum::fromValue($value)->key)
        ->value->toEqual(UsersEnum::fromValue($value)->value)
        ->description->toEqual(__('enums.App\Enums\UsersEnum.' . $value));
})->with([
    [UsersEnum::SUPER],
    [UsersEnum::EXAMPLE],
]);
