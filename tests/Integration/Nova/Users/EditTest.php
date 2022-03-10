<?php

it('has users fields for super admin user', function () {
    // superUser
    $authed = $this->loginAsAdmin();

    $this->novaEdit('users', $authed->id)
         ->assertFieldsInclude('email')
         ->assertFieldsInclude(['email', 'name', 'password', 'roles', 'permissions'])
         ->assertFieldsInclude(['email' => $authed->email, 'name' => $authed->name])
         ->assertFieldsExclude('id')
         ->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at'])
         ->assertFields(fn ($fields) => $fields->count() === 5);
});

it('has some users fields for content manager user', function () {
    // normal user
    $authed = $this->loginAsEditor();

    $this->novaEdit('users', $authed->id)
         ->assertFieldsInclude('email')
         ->assertFieldsInclude(['email', 'name', 'password'])
         ->assertFieldsInclude(['email' => $authed->email, 'name' => $authed->name])
         ->assertFieldsExclude('id')
         ->assertFieldsExclude(['remember_token', 'deleted_at', 'created_at', 'updated_at'])
         ->assertFields(fn ($fields) => $fields->count() === 3);
});
