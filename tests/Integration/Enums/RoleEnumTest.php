<?php

use Pest\Expectation;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;

it('has a corresponding enum value', closure: fn () => expect(RoleEnum::cases())
    ->toHaveCount(2)
    ->each(fn (Expectation $expectation) => expect($expectation->value->value)->toBeString()));

it('has a permissions method', closure: fn () => expect(RoleEnum::SuperAdmin)
    ->permissions()
    ->toHaveCount(count(PermissionEnum::cases()))
    ->and(
        expect(RoleEnum::Content)->permissions()->toHaveCount(5)
    )
);
