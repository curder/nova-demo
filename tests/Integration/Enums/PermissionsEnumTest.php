<?php

use App\Enums\PermissionsEnum;

it('has availablePermissions static method on permissionsEnum class', fn () => expect(PermissionsEnum::availablePermissions())
    ->toBeCollection()->toHaveCount(28));

it('has groups static method on permissionsEnum class', fn () => expect(PermissionsEnum::groups())
    ->toBeArray()->toHaveCount(3));

it('has count static method on permissionsEnum class', fn () => expect(PermissionsEnum::count())
    ->toBeInt()->toBe(28));

it('has some dynamic static method #USERS', fn () => expect(PermissionsEnum::USERS())
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('USERS', 'users', __('enums.App\Enums\PermissionsEnum.users')));

it('has some dynamic static method #MANAGER_USERS', fn () => expect(PermissionsEnum::MANAGER_USERS())
    ->toBeInstanceOf(PermissionsEnum::class)
    ->toBeEnum('MANAGER_USERS', 'managerUsers', __('enums.App\Enums\PermissionsEnum.managerUsers')));
