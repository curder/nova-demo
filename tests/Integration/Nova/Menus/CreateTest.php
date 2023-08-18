<?php

use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->seed(UserSeeder::class);
});

it('has some fields for super admin user', function () {
    $this->loginAsAdmin();

    $this->novaCreate('nova-menus')
        ->assertFieldsInclude(['name', 'slug'])
        ->assertFieldsExclude(['id', 'created_at', 'updated_at']);
});

it('has forbidden for content manager user', function () {
    $this->loginAsEditor();

    $this->novaCreate('nova-menus')
        ->assertCannotCreate();
});
