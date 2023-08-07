<?php

use App\Enums;

beforeEach(function () {
    $this->group_count = 5;
    $this->available_count = 31;
});

it('has availablePermissions static method on permissionsEnum class', fn () => expect(Enums\Permission::availablePermissions())
    ->toBeCollection()->toHaveCount($this->available_count));

it('has groups static method on permissionsEnum class', fn () => expect(Enums\Permission::groups())
    ->toBeArray()->toHaveCount($this->group_count));

it('has count static method on permissionsEnum class', fn () => expect(Enums\Permission::count())
    ->toBeInt()->toBe($this->available_count));

it('has enum key value and label method for Users', fn () => expect(Enums\Permission::Users)
    ->toBeInstanceOf(Enums\Permission::class)
    ->toBeEnum('Users', 'users', '用户'));

it('has enum key value and label method for Roles', fn () => expect(Enums\Permission::Roles)
    ->toBeInstanceOf(Enums\Permission::class)
    ->toBeEnum('Roles', 'roles', '角色'));

it('has enum key value and label method for Permissions', fn () => expect(Enums\Permission::Permissions)
    ->toBeInstanceOf(Enums\Permission::class)
    ->toBeEnum('Permissions', 'permissions', '权限'));
