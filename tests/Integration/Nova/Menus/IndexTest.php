<?php

use App\Models\Menu;

beforeEach(function () {
    $this->menu = Menu::factory()->create();
    $this->authed = $this->loginAsAdmin();
});

it('can render menus index resources page', function () {
    $this->novaIndex('nova-menus')
         ->assertResourceCount(1)
         ->assertResources(fn ($resources) => $resources->count() === 1);
});

it('can render menus index resources fields', function () {
    $menu_slug = sprintf('<s>%s</s>', $this->menu->slug);
    $this->novaIndex('nova-menus')
         ->assertFieldsInclude('name')
         ->assertFieldsInclude(['name', 'slug', 'id'])
         ->assertFieldsInclude(['name' => $this->menu->name, 'slug' => $menu_slug])
         ->assertFieldsInclude('name', Menu::query()->get()->pluck('name'))
         // collection of field arrays
         ->assertFields(fn ($fields) => $fields->count() === 1 && count($fields->first()) === 3)
    ;
});
