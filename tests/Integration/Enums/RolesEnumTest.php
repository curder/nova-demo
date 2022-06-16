<?php

use App\Enums\RolesEnum;
use Illuminate\Support\Arr;

it('has users static method on RolesEnum class', fn () => expect(Arr::random(RolesEnum::getInstances())->users())->toBeCollection());

//it('will return empty collection when use faker value for users static method', fn () => expect(RolesEnum::users())
//    ->toBeCollection()
//    ->toBeEmpty());

it('has permissions static method', fn () => expect(RolesEnum::permissions(RolesEnum::getRandomValue()))
    ->toBeCollection());

it('will return empty collection when use faker value for permissions static method', fn () => expect(RolesEnum::permissions('faker-value'))
    ->toBeCollection()
    ->toBeEmpty());

it('has some items in RolesEnum class', function (string $value) {
    expect(RolesEnum::fromValue($value))
        ->toBeInstanceOf(RolesEnum::class)
        ->key->toEqual(RolesEnum::fromValue($value)->key)
        ->value->toEqual(RolesEnum::fromValue($value)->value)
        ->description->toEqual(__('enums.App\Enums\RolesEnum.' . $value));
})->with([
    [RolesEnum::SUPER_ADMIN],
    [RolesEnum::CONTENT],
]);
