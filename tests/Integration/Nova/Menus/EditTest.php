<?php

use App\Models\Menu;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
});

it('has menus fields', function () {
    // superUser
    $authed = $this->loginAsAdmin();

    $menu = Menu::factory()->create();
    $this->novaEdit('nova-menus', $menu->id)
        ->assertFieldsInclude(['name', 'slug'])
        ->assertFieldsInclude(['name' => $menu->name, 'slug' => $menu->slug])
        ->assertFieldsExclude(['id', 'created_at', 'updated_at'])
        ->assertFields(fn ($fields) => $fields->count() === 3);
});
