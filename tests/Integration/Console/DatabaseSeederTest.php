<?php

use App\Models;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class)
    ->beforeEach(fn () => $this->seed());

it('can see some init data in tables', function () {
    expect(Models\User::query()->get())->toHaveCount(2);
});
