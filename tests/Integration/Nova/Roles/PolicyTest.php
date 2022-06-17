<?php

namespace Tests\Integration\Nova\Users;

use App\Enums\PermissionsEnum;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserHasPermissionsSeeder;
use Database\Seeders\UserSeeder;
use Symfony\Component\HttpFoundation\Response;

beforeEach(closure: function () {
    $this->seed([
        UserSeeder::class,
        RolesAndPermissionsSeeder::class,
        UserHasPermissionsSeeder::class,
    ]);
});

it('has roles come policy', function () {
    // 超级管理员
    $this->loginAsAdmin();
    $response = $this->novaIndex('roles');
    $response->assertOk();
    $response->assertCanView();

    // 默认用户
    $this->loginAsEditor();
    $response = $this->novaIndex('roles');
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user can not view any', function () {
    $user = $this->loginAsAdmin();

    $this->novaIndex('roles')->assertOK();

    $role = $user->roles()->first();
    $role->revokePermissionTo(PermissionsEnum::MANAGER_ROLES);

    $this->novaIndex('roles')
         ->assertStatus(Response::HTTP_FORBIDDEN);
});
