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

it('has users come policy', function () {
    // 超级管理员
    $this->loginAsAdmin();
    $response = $this->novaIndex('users');
    $response->assertOk();
    $response->assertCanView();
    $response->assertCanCreate();
    $response->assertCanUpdate();
    $response->assertCanDelete();
    $response->assertCanForceDelete();
    $response->assertCanRestore();

    // 默认用户
    $this->loginAsEditor();
    $response = $this->novaIndex('users');
    $response->assertOk();
    $response->assertCanView();
    $response->assertCanNotCreate();
    $response->assertCanNotUpdate();
    $response->assertCanNotDelete();
    $response->assertCanNotForceDelete();
    $response->assertCanNotRestore();
});

it('has user can not view any', function () {
    $user = $this->loginAsEditor();
    $role = $user->roles()->first();

    $role->revokePermissionTo(PermissionsEnum::ManagerUsers->value);

    $this->novaIndex('users')
        ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user policy can not asserts', function () {
    $user = $this->loginAsEditor();

    $revoke_permissions = [
        PermissionsEnum::CreateUsers->value,
        PermissionsEnum::UpdateUsers->value,
        PermissionsEnum::DeleteUsers->value,
        PermissionsEnum::ForceDeleteUsers->value,
        PermissionsEnum::RestoreUsers->value,
    ];

    $user->revokePermissionTo($revoke_permissions);

    $response = $this->novaIndex('users');

    $response->assertCannotCreate();
    $response->assertCannotUpdate();
    $response->assertCannotDelete();
    $response->assertCannotForceDelete();
    $response->assertCannotRestore();
});
