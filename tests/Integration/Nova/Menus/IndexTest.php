<?php

use App\Models\Menu;
use Database\Seeders\UserSeeder;

beforeEach(function () {
    $this->seed(UserSeeder::class);
    $this->authed = $this->loginAsAdmin();
});

it('can render menus index resources page', function () {
    $menu = Menu::factory()->create();
    $this->novaIndex('nova-menus')
        ->assertFieldsInclude(['name' => $menu->name, 'slug' => '<s>'.$menu->slug.'</s>'])
        ->assertResourceCount(1);
});

it('can render menus index resources fields', function () {
    Menu::factory()->create();

    $this->novaIndex('nova-menus')
         // collection of field arrays
        ->assertFields(fn ($fields) => $fields->count() === 1 && count($fields->first()) === 3);
});
