<?php

namespace Tests\Integration\Nova\Users;

use App\Models\Permission;
use App\Models\Role;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;

beforeEach(closure: function () {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
});

it('can show roles fields', function () {
    /** @var \App\Models\User $authed */
    $this->loginAsAdmin();
    $role = Role::query()->first();

    $this->novaDetail('roles', $role?->id)
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'name', 'guard_name', 'created_at', 'updated_at', 'permissions'])
         ->assertFields(fn ($fields) => $fields->count() === 7);
});
