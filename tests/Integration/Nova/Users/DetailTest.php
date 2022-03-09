<?php

uses(\Tests\Integration\Nova\TestCase::class);

it('can show users fields', function () {
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
});
