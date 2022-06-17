<?php

namespace Tests\Integration\Nova\Users;

use App\Models\Permission;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;

beforeEach(closure: function () {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
});

it('can show permissions fields', function () {
    /** @var \App\Models\User $authed */
    $this->loginAsAdmin();
    $permission = Permission::query()->first();

    $this->novaDetail('permissions', $permission?->id)
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'name', 'guard_name', 'created_at', 'updated_at', 'roles', 'users'])
         ->assertFields(fn ($fields) => $fields->count() === 7);
});
