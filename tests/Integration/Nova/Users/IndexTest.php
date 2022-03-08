<?php

namespace Tests\Integration\Nova\Users;

use App\Models\User;
use Tests\Integration\Nova\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function it_can_render_users_index_resources_page(): void
    {
        $authed = $this->loginAdminUser();

        $response = $this->novaIndex('users');

        $response->assertResourceCount(2);
        $response->assertResources(function ($resources) {
            return $resources->count() === 2;
        });
    }

    /** @test */
    public function it_can_render_users_index_resources_fields(): void
    {
        $authed = $this->loginAdminUser();

        $response = $this->novaIndex('users');

        $response->assertFieldsInclude('id');
        $response->assertFieldsInclude(['id', 'email', 'name', 'roles', 'permissions']);
        $response->assertFieldsInclude(['id' => $authed->id, 'email' => $authed->email]);
        $response->assertFieldsInclude('id', User::query()->get()->pluck('id'));

        $response->assertFields(function ($fields) {
            // collection of field arrays
            return $fields->count() === 2 && count($fields->first()) === 6;
        });
    }
}
