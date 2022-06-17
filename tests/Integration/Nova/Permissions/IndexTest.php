<?php

namespace Tests\Integration\Nova\Users;

use App\Enums\PermissionsEnum;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;

beforeEach(closure: function (): void {
    $this->seed([UserSeeder::class, RolesAndPermissionsSeeder::class]);
    $this->authed = $this->loginAsAdmin();
});

it('can render permissions index resources page', function () {
    $response = $this->novaIndex('permissions');

    $this->assertEquals(
        $response->originalResponse()->baseResponse->original['total'],
        PermissionsEnum::count()
    );
});

it('can render permissions index resources fields', function () {
    $this->novaIndex('permissions')
         ->assertFieldsInclude('id')
         ->assertFieldsInclude(['id', 'name', 'guard_name', 'created_at', 'updated_at', 'roles'])
        // collection of field arrays
         ->assertFields(fn ($fields) => count($fields->first()) === 6);
});
