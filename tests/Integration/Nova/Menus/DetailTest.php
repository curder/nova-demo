<?php

use App\Models\Menu;

beforeEach(function () {
    $this->menu = Menu::factory()->create();
    $this->authed = $this->loginAsAdmin();
});

it('can show menus fields', function () {
    $slug = sprintf("<s>%s</s>", $this->menu->slug);

    $this->novaDetail('nova-menus', $this->menu->id)
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'name', 'slug'])
         ->assertFieldsInclude(['id' => $this->menu->id, 'name' => $this->menu->name, 'slug' => $slug])
         ->assertFieldsExclude(['created_at' => $this->menu->created_at, 'updated_at' => $this->menu->updated_at])
         ->assertFields(fn ($fields) => $fields->count() === 3)
    ;
});
