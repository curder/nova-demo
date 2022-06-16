<?php

use App\Enums\PermissionsEnum;

beforeEach(function () {
    $this->group_count = 4;
    $this->available_count = 33;
});

it('has availablePermissions static method on permissionsEnum class', fn () => expect(PermissionsEnum::availablePermissions())
    ->toBeCollection()->toHaveCount($this->available_count));

it('has groups static method on permissionsEnum class', fn () => expect(PermissionsEnum::groups())
    ->toBeArray()->toHaveCount($this->group_count));

it('has count static method on permissionsEnum class', fn () => expect(PermissionsEnum::count())
    ->toBeInt()->toBe($this->available_count));

it('has some items in PermissionsEnum class', function (string $value) {
    expect(PermissionsEnum::fromValue($value))
        ->toBeInstanceOf(PermissionsEnum::class)
        ->key->toEqual(PermissionsEnum::fromValue($value)->key)
        ->value->toEqual(PermissionsEnum::fromValue($value)->value)
        ->description->toEqual(__('enums.App\Enums\PermissionsEnum.' . $value));
})->with([
    [PermissionsEnum::USERS],
    [PermissionsEnum::ROLES],
    [PermissionsEnum::PERMISSIONS],
    [PermissionsEnum::MENUS],
]);
