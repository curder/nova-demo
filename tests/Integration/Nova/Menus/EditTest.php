<?php

use App\Models\Menu;
use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->seed(UserSeeder::class);
});

it('has menus fields', function () {
    // superUser
    $this->loginAsAdmin();

    $menu = Menu::factory()->create();
    $this->novaEdit('nova-menus', $menu->id)
        ->assertFieldsInclude(['name' => $menu->name, 'slug' => $menu->slug])
        ->assertFieldsExclude(['id', 'created_at', 'updated_at'])
        ->assertFields(fn ($fields) => $fields->count() === 3);
});
