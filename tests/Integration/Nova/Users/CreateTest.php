<?php

uses(\Tests\Integration\Nova\TestCase::class);

it('has some fields for super admin user', function () {
    $authed = $this->loginAdminUser();

    $response = $this->novaCreate('users');
    $response->assertFieldsInclude('email');
    $response->assertFieldsInclude(['email', 'name', 'password', 'roles', 'permissions']);

    $response->assertFieldsExclude('id');
    $response->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at']);

    $response->assertFields(function ($fields) {
        return $fields->count() === 5;
    });
});

it('has some fields for content manager user', function () {
    $authed = $this->loginContentUser();

    $response = $this->novaCreate('users');

    $response->assertFieldsInclude('email');
    $response->assertFieldsInclude(['email', 'name', 'password']);

    $response->assertFieldsExclude('id');
    $response->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at']);

    $response->assertFields(function ($fields) {
        return $fields->count() === 3;
    });
});
