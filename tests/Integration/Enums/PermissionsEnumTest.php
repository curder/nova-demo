<?php

use App\Enums;
use App\Traits\Enums\InteractsWithOptions;

it('has availablePermissions static method on permissionsEnum class', fn () => expect(Enums\PermissionEnum::cases())
    ->toHaveCount(9));

it('include setting traits', function () {
    return expect(new ReflectionEnum(Enums\PermissionEnum::class))
        ->getTraits()
        ->toHaveCount(1)
        ->sequence(
            fn ($obj, $trait) => $trait->toBe(InteractsWithOptions::class),
        );
});
