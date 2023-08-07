<?php

use App\Enums;
use App\Models;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class)
    ->beforeEach(fn () => $this->seed());

it('can see some init data in tables', function () {
    expect(Models\User::query()->get())->toHaveCount(2);
    expect(Enums\Permission::count())->toEqual(Models\Permission::query()->count());
    expect(Models\Role::query()->get())->toHaveCount(Enums\Role::count());
});
