<?php

namespace Tests\Integration\Nova\Users;

use App\Enums;
use App\Models;
use Database\Seeders;

beforeEach(closure: function (): void {
    $this->seed(Seeders\UserSeeder::class);
    $this->authed = $this->loginAsAdmin();
});

it('can render users index resources page', function () {
    $this->novaIndex('users')
        ->assertResourceCount(count(Enums\UserEnum::cases()))
        ->assertResources(fn ($resources) => $resources->count() === count(Enums\UserEnum::cases()));
});

it('can render users index resources fields', function () {
    $this->novaIndex('users')
        ->assertFieldsInclude('id')
        ->assertFieldsInclude(['id', 'email', 'name'])
        ->assertFieldsInclude(['id' => $this->authed->id, 'email' => $this->authed->email])
        ->assertFieldsInclude('id', Models\User::query()->get()->pluck('id'))
        // collection of field arrays
        ->assertFields(fn ($fields) => $fields->count() === count(Enums\UserEnum::cases()) && count($fields->first()) === 3);
});
