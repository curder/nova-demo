<?php

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Curder\NovaPermission\Models\Permission;
use Curder\NovaPermission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('can see some init data in tables', function () {
    $this->seed();

    $this->assertSame(2, User::query()->count());
    $this->assertSame(PermissionsEnum::count(), Permission::query()->count());
    $this->assertSame(RolesEnum::count(), Role::query()->count());
});
