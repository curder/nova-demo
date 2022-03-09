<?php

use Tests\Integration\Nova\TestCase;

uses(TestCase::class);

it('has users fields for super admin user', function () {
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
});
it('has some users fields for content manager user', function () {
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
});
