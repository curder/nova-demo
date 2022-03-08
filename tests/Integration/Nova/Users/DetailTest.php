<?php

namespace Tests\Integration\Nova\Users;

use Tests\Integration\Nova\TestCase;

/**
 * Class DetailTest
 *
 * @package \Tests\Integration\Nova\Users
 */
class DetailTest extends TestCase
{
    /** @test */
    public function it_can_show_fields(): void
    {
        // superUser
        $authed = $this->loginAdminUser();

        $response = $this->novaDetail('users', $authed->id);

        $response->assertFieldsInclude('id');
        $response->assertFieldsInclude(['id', 'email', 'name', 'roles', 'permissions']);
        $response->assertFieldsInclude(['id' => $authed->id, 'email' => $authed->email]);

        $response->assertFieldsExclude('created_at');
        $response->assertFieldsExclude(['email_verified_at', 'remember_token', 'deleted_at', 'created_at', 'updated_at']);
        $response->assertFieldsExclude(['created_at' => $authed->created_at, 'updated_at' => $authed->updated_at]);

        $response->assertFields(function ($fields) {
            return $fields->count() === 6;
        });
    }
}
