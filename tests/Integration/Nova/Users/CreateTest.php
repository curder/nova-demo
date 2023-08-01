<?php

namespace Tests\Integration\Nova\Users;

use App\Enums\PermissionsEnum;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;

beforeEach(closure: function () {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
});

it('has some fields for super admin user', function () {
    $authed = $this->loginAsAdmin();

    $this->novaCreate('users')
        ->assertFieldsInclude('email')
        ->assertFieldsInclude(['email', 'name', 'password'])
        ->assertFieldsExclude('id')
        ->assertFieldsExclude(['roles', 'permissions', 'remember_token', 'deleted_at', 'created_at', 'updated_at'])
        ->assertFields(fn ($fields) => $fields->count() === 3);
});

it('has some fields for content manager user', function () {
    $authed = $this->loginAsEditor();

    $authed->givePermissionTo(PermissionsEnum::CreateUsers->value);

    $this->novaCreate('users')
        ->assertFieldsInclude('email')
        ->assertFieldsInclude(['email', 'name', 'password'])
        ->assertFieldsExclude('id')
        ->assertFieldsExclude(['roles', 'permissions', 'remember_token', 'deleted_at', 'created_at', 'updated_at'])
        ->assertFields(fn ($fields) => $fields->count() === 3);
});
