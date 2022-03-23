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

it('has some dynamic static method #USERS', fn () => expect(PermissionsEnum::USERS())
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('USERS', 'users', __('enums.App\Enums\PermissionsEnum.users')));

it('has some dynamic static method #MANAGER_USERS', fn () => expect(PermissionsEnum::MANAGER_USERS())
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('MANAGER_USERS', 'managerUsers', __('enums.App\Enums\PermissionsEnum.managerUsers')));
