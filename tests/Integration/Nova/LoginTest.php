<?php

use Database\Seeders\UserSeeder;

use function Pest\Laravel\get;

it('can redirect correct url when user login in', function () {
    get('/cp/login')->assertOk();

    $this->seed(UserSeeder::class);
    $this->loginAsAdmin();

    get('/cp/login')->assertRedirect('/cp');
    get('/cp')->assertRedirect('cp/resources/users');
});
