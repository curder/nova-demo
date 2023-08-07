<?php

namespace Tests\Integration\Nova\Users;

use App\Enums;
use Database\Seeders;
use Symfony\Component\HttpFoundation\Response;

beforeEach(closure: function () {
    $this->seed([
        Seeders\UserSeeder::class,
        Seeders\RolesAndPermissionsSeeder::class,
        Seeders\UserHasPermissionsSeeder::class,
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

    $role->revokePermissionTo(Enums\Permission::ManagerUsers->value);

    $this->novaIndex('users')
        ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user policy can not asserts', function () {
    $user = $this->loginAsEditor();

    $revoke_permissions = [
        Enums\Permission::CreateUsers->value,
        Enums\Permission::UpdateUsers->value,
        Enums\Permission::DeleteUsers->value,
        Enums\Permission::ForceDeleteUsers->value,
        Enums\Permission::RestoreUsers->value,
    ];

    $user->revokePermissionTo($revoke_permissions);

    $response = $this->novaIndex('users');

    $response->assertCannotCreate();
    $response->assertCannotUpdate();
    $response->assertCannotDelete();
    $response->assertCannotForceDelete();
    $response->assertCannotRestore();
});
