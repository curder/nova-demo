<?php

use App\Models\Menu;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
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
    $response->assertForbidden();

    $response->assertCanNotCreate();
//    $response->assertCanNotDelete();
});

it('has user can not view signal menu', function () {
    $user = $this->loginAsEditor();

    $this->novaDetail('nova-menus', $this->menu->id)
          ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user can not edit signal menu', function () {
    $user = $this->loginAsEditor();

    $this->novaEdit('nova-menus', $this->menu->id)
         ->assertStatus(Response::HTTP_FORBIDDEN);
});
