<?php

use Tests\TestCase;
use App\Models\User;
use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Curder\NovaPermission\Models\Role;
use Curder\NovaPermission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class, RefreshDatabase::class);

it('can see some init data in tables', function () {
    $this->seed();

    $this->assertSame(2, User::query()->count());
    $this->assertSame(PermissionsEnum::count(), Permission::query()->count());
    $this->assertSame(RolesEnum::count(), Role::query()->count());
});
