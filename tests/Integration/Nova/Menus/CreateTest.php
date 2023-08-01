<?php

use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
});

it('has some fields for super admin user', function () {
    $authed = $this->loginAsAdmin();

    $this->novaCreate('nova-menus')
        ->assertFieldsInclude('name')
        ->assertFieldsInclude(['name', 'slug'])
        ->assertFieldsExclude('id')
        ->assertFieldsExclude(['created_at', 'updated_at'])
        ->assertFields(fn ($fields) => $fields->count() === 2);
});

it('has forbidden for content manager user', function () {
    $this->loginAsEditor();

    $this->novaCreate('nova-menus')
        ->assertCannotCreate();
});
