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

it('has enum key value and label method for Users', fn () => expect(PermissionsEnum::USERS)
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('USERS', 'users', '用户'));

it('has enum key value and label method for Roles', fn () => expect(PermissionsEnum::ROLES)
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('ROLES', 'roles', '角色'));

it('has enum key value and label method for Permissions', fn () => expect(PermissionsEnum::PERMISSIONS)
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('PERMISSIONS', 'permissions', '权限'));
