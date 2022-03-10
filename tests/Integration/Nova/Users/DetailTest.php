<?php

it('can show users fields', function () {
    // superUser
    $authed = $this->loginAsAdmin();

    $this->novaDetail('users', $authed->id)
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'email', 'name', 'roles', 'permissions'])
         ->assertFieldsInclude(['id' => $authed->id, 'email' => $authed->email])
         ->assertFieldsExclude('created_at')
         ->assertFieldsExclude(['email_verified_at', 'remember_token', 'deleted_at', 'created_at', 'updated_at'])
         ->assertFieldsExclude(['created_at' => $authed->created_at, 'updated_at' => $authed->updated_at])
         ->assertFields(fn ($fields) => $fields->count() === 7);
});
