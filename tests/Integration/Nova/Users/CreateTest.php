<?php

namespace Tests\Integration\Nova\Users;

use App\Models\User;
use App\Enums\RolesEnum;
use NovaTesting\NovaAssertions;
use Tests\Integration\Nova\TestCase;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

/**
 * Class CreateTest
 *
 * @package \Tests\Integration\Nova\Users
 */
class CreateTest extends TestCase
{

    /** @test */
    public function it_has_some_fields_for_super_admin_user(): void
    {
        $authed = $this->loginAdminUser();

        $response = $this->novaCreate('users');
        $response->assertFieldsInclude('email');
        $response->assertFieldsInclude(['email', 'name', 'password', 'roles', 'permissions']);

        $response->assertFieldsExclude('id');
        $response->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at']);

        $response->assertFields(function ($fields) {
            return $fields->count() === 5;
        });
    }

    /** @test */
    public function it_has_some_fields_for_content_manager_user(): void
    {
        // normal user
        $authed = $this->loginContentUser();

        $response = $this->novaCreate('users');

        $response->assertFieldsInclude('email');
        $response->assertFieldsInclude(['email', 'name', 'password']);

        $response->assertFieldsExclude('id');
        $response->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at']);

        $response->assertFields(function ($fields) {
            return $fields->count() === 3;
        });
    }

}
