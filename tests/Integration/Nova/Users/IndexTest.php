<?php

use App\Models\User;

beforeEach(fn () => $this->authed = $this->loginAsAdmin());

it('can render users index resources page', function () {
    $this->novaIndex('users')
         ->assertResourceCount(2)
         ->assertResources(fn($resources) => $resources->count() === 2);
});

it('can render users index resources fields', function () {
    $this->novaIndex('users')
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'email', 'name', 'roles', 'permissions'])
         ->assertFieldsInclude(['id' => $this->authed->id, 'email' => $this->authed->email])
         ->assertFieldsInclude('id', User::query()->get()->pluck('id'))
         // collection of field arrays
         ->assertFields(fn($fields) => $fields->count() === 2 && count($fields->first()) === 6);
});
