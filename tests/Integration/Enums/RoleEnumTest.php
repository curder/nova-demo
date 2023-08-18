<?php

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Pest\Expectation;

it('has a corresponding enum value', closure: fn () => expect(RoleEnum::cases())
    ->toHaveCount(2)
    ->each(fn (Expectation $expectation) => expect($expectation->value->value)->toBeString()));

it('has a permissions method', closure: fn () => expect(RoleEnum::SuperAdmin)
    ->toHaveMethod('permissions')
    ->permissions(RoleEnum::SuperAdmin->value)
    ->toHaveCount(count(PermissionEnum::cases()))
    ->and(
        expect(RoleEnum::Content)->permissions()->toHaveCount(5)
    )
);
