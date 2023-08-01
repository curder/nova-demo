<?php

use App\Enums\PermissionsEnum;

beforeEach(function () {
    $this->group_count = 5;
    $this->available_count = 31;
});

it('has availablePermissions static method on permissionsEnum class', fn () => expect(PermissionsEnum::availablePermissions())
    ->toBeCollection()->toHaveCount($this->available_count));

it('has groups static method on permissionsEnum class', fn () => expect(PermissionsEnum::groups())
    ->toBeArray()->toHaveCount($this->group_count));

it('has count static method on permissionsEnum class', fn () => expect(PermissionsEnum::count())
    ->toBeInt()->toBe($this->available_count));

it('has enum key value and label method for Users', fn () => expect(PermissionsEnum::Users)
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('Users', 'users', '用户'));

it('has enum key value and label method for Roles', fn () => expect(PermissionsEnum::Roles)
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('Roles', 'roles', '角色'));

it('has enum key value and label method for Permissions', fn () => expect(PermissionsEnum::Permissions)
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('Permissions', 'permissions', '权限'));
