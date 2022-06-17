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

it('has permissions come policy', function () {
    // 超级管理员
    $this->loginAsAdmin();
    $response = $this->novaIndex('permissions');
    $response->assertOk();
    $response->assertCanView();

    // 默认用户
    $this->loginAsEditor();
    $response = $this->novaIndex('permissions');
    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user can not view any', function () {
    $user = $this->loginAsAdmin();

    $this->novaIndex('permissions')->assertOK();

    $role = $user->roles()->first();
    $role->revokePermissionTo(PermissionsEnum::MANAGER_PERMISSIONS);

    $this->novaIndex('permissions')
         ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user policy can not asserts', function () {
    $user = $this->loginAsAdmin();

    $revoke_permissions = [
        PermissionsEnum::CREATE_USERS,
    ];

    $user->revokePermissionTo($revoke_permissions);

    $response = $this->novaIndex('permissions');

    $response->assertCannotCreate();
});
