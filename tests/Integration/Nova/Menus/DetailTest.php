<?php

use App\Models\Menu;
use Database\Seeders\UserSeeder;

it('can show menus fields', function () {

    $this->seed(UserSeeder::class);
    $this->loginAsAdmin();
    $menu = Menu::factory()->create();

    $this->novaDetail('nova-menus', $menu->id)
        ->assertFieldsInclude(['id' => $menu->id, 'name' => $menu->name, 'slug' => '<s>'.$menu->slug.'</s>'])
        ->assertFieldsExclude(['created_at' => $menu->created_at, 'updated_at' => $menu->updated_at]);
});
