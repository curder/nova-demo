<?php

use App\Enums\RolesEnum;

it('has users static method on RolesEnum class', fn () => expect(RolesEnum::users(RolesEnum::getRandomValue()))
    ->toBeCollection());

it('will return empty collection when use faker value for users static method', fn () => expect(RolesEnum::users('faker-value'))
    ->toBeCollection()
    ->toBeEmpty());

it('has permissions static method', fn () => expect(RolesEnum::permissions(RolesEnum::getRandomValue()))
    ->toBeCollection());

it('will return empty collection when use faker value for permissions static method', fn () => expect(RolesEnum::permissions('faker-value'))
    ->toBeCollection()
    ->toBeEmpty());

it('has some dynamic static method #SUPERADMIN', fn () => expect(RolesEnum::SUPER_ADMIN())
    ->toBeInstanceOf(RolesEnum::class)
    ->toBeEnum('SUPER_ADMIN', 'superAdmin', __('enums.App\Enums\RolesEnum.superAdmin')));

it('has some dynamic static method #CONTENT', fn () => expect(RolesEnum::CONTENT())
    ->toBeInstanceOf(RolesEnum::class)
    ->toBeEnum('CONTENT', 'content', __('enums.App\Enums\RolesEnum.content')));
