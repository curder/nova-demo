<?php

namespace Tests\Integration\Nova\Users;

use App\Enums\PermissionsEnum;
use Tests\Integration\Nova\TestCase;

/**
 * Class PolicyTest
 *
 * @package \Tests\Integration\Nova\Users
 */
class PolicyTest extends TestCase
{
    /** @test */
    public function it_has_come_policy(): void
    {
        $user = $this->loginAdminUser();
        $response = $this->novaIndex('users');
        $response->assertOk();
        $response->assertCanView();
        $response->assertCanCreate();
        $response->assertCanUpdate();
        $response->assertCanDelete();
        $response->assertCanForceDelete();
        $response->assertCanRestore();

        $user = $this->loginContentUser();
        $response = $this->novaIndex('users');
        $response->assertOk();
        $response->assertCanView();
        $response->assertCanCreate();
        $response->assertCanUpdate();
        $response->assertCanNotDelete();
        $response->assertCanNotForceDelete();
        $response->assertCanNotRestore();
    }

    /**
     * @test
     */
    public function can_not_view_any(): void
    {
        $user = $this->loginContentUser();
        $role = $user->roles()->first();

        $role->revokePermissionTo(PermissionsEnum::MANAGER_USERS);

        $response = $this->novaIndex('users');

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function policy_can_not_asserts(): void
    {
        $user = $this->loginContentUser();

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
    }
}
