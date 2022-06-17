<?php

namespace Tests\Integration\Nova\Users;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(closure: function (): void {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
    $this->authed = $this->loginAsAdmin();
});

it('can render roles index resources page', function () {
    $response = $this->novaIndex('roles');

    $this->assertEquals(
        $response->originalResponse()->baseResponse->original['total'],
        RolesEnum::count()
    );
});

it('can render roles index resources fields', function () {
    $this->novaIndex('roles')
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'name', 'guard_name', 'created_at', 'updated_at', 'permissions'])
        // collection of field arrays
         ->assertFields(fn ($fields) => count($fields->first()) === 6);
});
