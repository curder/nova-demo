<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)
    ->beforeEach(fn () => $this->seed());

it('can see some init data in tables', function () {
    expect(User::query()->get())->toHaveCount(2);
    expect(PermissionsEnum::count())->toEqual(Permission::query()->count());
    expect(Role::query()->get())->toHaveCount(RolesEnum::count());
});
