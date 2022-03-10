<?php

use App\Enums\RolesEnum;

it('has users static method on RolesEnum class', fn () => expect(array_rand(RolesEnum::cases())->users())->toBeCollection());

it('will return empty collection when use faker value for users static method', fn () => expect(RolesEnum::tryFrom('faker-value')?->users())
    ->toBeCollection()
    ->toBeEmpty());

it('has permissions static method', fn () => expect(RolesEnum::permissions(array_rand(RolesEnum::cases())))
    ->toBeCollection());

it('will return empty collection when use faker value for permissions static method', fn () => expect(RolesEnum::permissions('faker-value'))
    ->toBeCollection()
    ->toBeEmpty());

it('has enum key value and label method for SuperAdmin', fn () => expect(RolesEnum::SuperAdmin)
    ->toBeInstanceOf(RolesEnum::class)
    ->toBeEnum('SuperAdmin', 'superAdmin', '超级管理员'));

it('has enum key value and label method for Content', fn () => expect(RolesEnum::Content)
    ->toBeInstanceOf(RolesEnum::class)
    ->toBeEnum('Content', 'content', '内容管理员'));
