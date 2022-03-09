<?php

use App\Models\User;

uses(\Tests\Integration\Nova\TestCase::class);

it('can render users index resources page', function () {
    $authed = $this->loginAdminUser();

    $response = $this->novaIndex('users');

    $response->assertResourceCount(2);
    $response->assertResources(function ($resources) {
        return $resources->count() === 2;
    });
});

it('can render users index resources fields', function () {
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
});
