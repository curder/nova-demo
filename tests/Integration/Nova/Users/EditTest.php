<?php

namespace Tests\Integration\Nova\Users;

use Tests\Integration\Nova\TestCase;

/**
 * Class EditTest
 *
 * @package \Tests\Integration\Nova\Users
 */
class EditTest extends TestCase
{
    /** @test */
    public function it_has_fields_for_super_admin_user(): void
    {
        // superUser
        $authed = $this->loginAdminUser();

        $response = $this->novaEdit('users', $authed->id);
        $response->assertFieldsInclude('email');
        $response->assertFieldsInclude(['email', 'name', 'password', 'roles', 'permissions']);
        $response->assertFieldsInclude(['email' => $authed->email, 'name' => $authed->name]);

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

        $response = $this->novaEdit('users', $authed->id);
        $response->assertFieldsInclude('email');
        $response->assertFieldsInclude(['email', 'name', 'password']);
        $response->assertFieldsInclude(['email' => $authed->email, 'name' => $authed->name]);

        $response->assertFieldsExclude('id');
        $response->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at']);

        $response->assertFields(function ($fields) {
            return $fields->count() === 3;
        });
    }
}
