<?php

namespace Tests\Integration\Nova\Users;

use Database\Seeders;

beforeEach(closure: function () {
    $this->seed(Seeders\UserSeeder::class);
});

it('has users come policy', function () {
    // 超级管理员
    $this->loginAsAdmin();
    $this->novaIndex('users')
        ->assertOk()
        ->assertCanView()
        ->assertCanUpdate()
        ->assertCanNotDelete()
        ->assertCanNotForceDelete()
        ->assertCanNotRestore()
        ->assertCanNotCreate();

    // 默认用户
    $this->loginAsEditor();
    $this->novaIndex('users')
        ->assertOk()
        ->assertCanView()
        ->assertCanNotUpdate()
        ->assertCanNotDelete()
        ->assertCanNotForceDelete()
        ->assertCanNotRestore()
        ->assertCanNotCreate();
});

it('has user can view any', function () {
    $this->loginAsEditor();

    $this->novaIndex('users')
        ->assertOk();
});

it('has user policy can not asserts', function () {
    $user = $this->loginAsEditor();

    $response = $this->novaIndex('users');

    $response->assertCannotCreate();
    $response->assertCannotUpdate();
    $response->assertCannotDelete();
    $response->assertCannotForceDelete();
    $response->assertCannotRestore();
});
