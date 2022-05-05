<?php

namespace Tests\Integration\Nova\Users;

use App\Enums\UsersEnum;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\UserSeeder;

beforeEach(closure: function (): void {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
    $this->authed = $this->loginAsAdmin();
});

it('can render users index resources page', function () {
    $this->novaIndex('users')
         ->assertResourceCount(UsersEnum::count())
         ->assertResources(fn ($resources) => $resources->count() === UsersEnum::count());
});

it('can render users index resources fields', function () {
    $this->novaIndex('users')
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'email', 'name', 'roles', 'permissions'])
         ->assertFieldsInclude(['id' => $this->authed->id, 'email' => $this->authed->email])
         ->assertFieldsInclude('id', User::query()->get()->pluck('id'))
        // collection of field arrays
         ->assertFields(fn ($fields) => $fields->count() === UsersEnum::count() && count($fields->first()) === 7);
});
