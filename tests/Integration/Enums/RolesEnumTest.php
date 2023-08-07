<?php

use App\Enums;
use Illuminate\Support\Arr;

it('has users static method on RolesEnum class', fn () => expect(Arr::random(Enums\Role::cases())->users())->toBeCollection());

//it('will return empty collection when use faker value for users static method', fn () => expect(RolesEnum::users())
//    ->toBeCollection()
//    ->toBeEmpty());

it('has permissions static method', fn () => expect(Enums\Role::permissions(array_rand(Enums\Role::cases())))
    ->toBeCollection());

it('will return empty collection when use faker value for permissions static method', fn () => expect(Enums\Role::permissions('faker-value'))
    ->toBeCollection()
    ->toBeEmpty());

it('has enum key value and label method for SuperAdmin', fn () => expect(Enums\Role::SuperAdmin)
    ->toBeInstanceOf(Enums\Role::class)
    ->toBeEnum('SuperAdmin', 'Super Admin', '超级管理员'));

it('has enum key value and label method for Content', fn () => expect(Enums\Role::Content)
    ->toBeInstanceOf(Enums\Role::class)
    ->toBeEnum('Content', 'Content', '编辑员'));
