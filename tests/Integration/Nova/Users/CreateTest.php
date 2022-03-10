<?php

it('has some fields for super admin user', function () {
    $authed = $this->loginAsAdmin();

    $this->novaCreate('users')
         ->assertFieldsInclude('email')
         ->assertFieldsInclude(['email', 'name', 'password', 'roles', 'permissions'])
         ->assertFieldsExclude('id')
         ->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at'])
         ->assertFields(fn($fields) => $fields->count() === 5);
});

it('has some fields for content manager user', function () {
    $authed = $this->loginAsEditor();

    $this->novaCreate('users')
         ->assertFieldsInclude('email')
         ->assertFieldsInclude(['email', 'name', 'password'])
         ->assertFieldsExclude('id')
         ->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at'])
         ->assertFields(fn($fields) => $fields->count() === 3);
});
