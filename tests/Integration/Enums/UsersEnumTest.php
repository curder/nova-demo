<?php

use App\Enums\UserEnum;
use Pest\Expectation;

it('has a corresponding enum value', closure: fn () => expect(enum_exists(UserEnum::class))
    ->toBeTrue()
    ->and(
        expect(UserEnum::cases())
            ->toHaveCount(2)
            ->each(fn (Expectation $expectation) => expect($expectation->value->value)->toBeString())
    )
);

it('has isSuperAdmin method', function () {
    expect(UserEnum::Super)->isSuperAdmin()->toBeTrue()
        ->and(UserEnum::Example)->isSuperAdmin()->not->toBeTrue();
});

it('has canImpersonate method', function () {
    expect(UserEnum::Super)->canImpersonate()->toBeTrue()
        ->and(UserEnum::Example)->canImpersonate()->not->toBeTrue();
});
