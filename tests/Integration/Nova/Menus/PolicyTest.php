<?php

use App\Models\Menu;
use Database\Seeders\UserSeeder;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->seed(UserSeeder::class);
    $this->menu = Menu::factory()->create();
});

it('has menus come policy', function () {
    $this->loginAsAdmin();
    $this->novaIndex('nova-menus')
        ->assertOk()
        ->assertCanView()
        ->assertCanUpdate()
        ->assertCanDelete()
        ->assertCanCreate();

    $this->loginAsEditor();
    $this->novaIndex('nova-menus')
        ->assertOk()
        ->assertCanNotUpdate()
        ->assertCanNotDelete()
        ->assertCanNotCreate();
});

it('has user can not view signal menu', function () {
    $this->loginAsEditor();

    $this->novaDetail('nova-menus', $this->menu->id)
        ->assertOK();
});

it('has user can not edit signal menu', function () {
    $this->loginAsEditor();
    $this->novaEdit('nova-menus', 1)
        ->assertStatus(Response::HTTP_FORBIDDEN);
});
