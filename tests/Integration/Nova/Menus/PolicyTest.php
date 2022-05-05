<?php

use App\Models\Menu;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
    $this->menu = Menu::factory()->create();
});

it('has menus come policy', function () {
    $user = $this->loginAsAdmin();
    $response = $this->novaIndex('nova-menus');

    $response->assertOk();
    $response->assertCanView();
    $response->assertCanCreate();
    $response->assertCanUpdate();
    $response->assertCanDelete();

    $user = $this->loginAsEditor();
    $response = $this->novaIndex('nova-menus');
    $response->assertOk();

    $response->assertCanNotCreate();
    $response->assertCanNotUpdate();
    $response->assertCanNotDelete();
});

it('has user can not view signal menu', function () {
    $user = $this->loginAsEditor();

    $this->novaDetail('nova-menus', $this->menu->id)
         ->assertOK();
});

it('has user can not edit signal menu', function () {
    $user = $this->loginAsEditor();

    $this->novaEdit('nova-menus', $this->menu->id)
         ->assertStatus(Response::HTTP_FORBIDDEN);
});
