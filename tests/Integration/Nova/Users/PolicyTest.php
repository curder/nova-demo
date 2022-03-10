<?php

use App\Enums\PermissionsEnum;
use Symfony\Component\HttpFoundation\Response;

it('has users come policy', function () {
    $user = $this->loginAsAdmin();
    $response = $this->novaIndex('users');
    $response->assertOk();
    $response->assertCanView();
    $response->assertCanCreate();
    $response->assertCanUpdate();
    $response->assertCanDelete();
    $response->assertCanForceDelete();
    $response->assertCanRestore();

    $user = $this->loginAsEditor();
    $response = $this->novaIndex('users');
    $response->assertOk();
    $response->assertCanView();
    $response->assertCanCreate();
    $response->assertCanUpdate();
    $response->assertCanNotDelete();
    $response->assertCanNotForceDelete();
    $response->assertCanNotRestore();
});

it('has user can not view any', function () {
    $user = $this->loginAsEditor();
    $role = $user->roles()->first();

    $role->revokePermissionTo(PermissionsEnum::MANAGER_USERS);

    $this->novaIndex('users')
          ->assertStatus(Response::HTTP_FORBIDDEN);
});

it('has user policy can not asserts', function () {
    $user = $this->loginAsEditor();

    $revoke_permissions = [
        PermissionsEnum::CREATE_USERS,
        PermissionsEnum::UPDATE_USERS,
        PermissionsEnum::DELETE_USERS,
        PermissionsEnum::FORCE_DELETE_USERS,
        PermissionsEnum::RESTORE_USERS,
    ];

    $user->revokePermissionTo($revoke_permissions);

    $response = $this->novaIndex('users');

    $response->assertCannotCreate();
    $response->assertCannotUpdate();
    $response->assertCannotDelete();
    $response->assertCannotForceDelete();
    $response->assertCannotRestore();
});
