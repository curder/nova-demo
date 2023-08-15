<?php

use App\Enums;

beforeEach(function () {
    $this->group_count = 5;
    $this->available_count = 31;
});

it('has availablePermissions static method on permissionsEnum class', fn () => expect(Enums\Permission::availablePermissions())->toHaveCount($this->available_count));

it('has groups static method on permissionsEnum class', fn () => expect(Enums\Permission::groups())
    ->toBeArray()->toHaveCount($this->group_count));

it('has count static method on permissionsEnum class', fn () => expect(Enums\Permission::count())
    ->toBeInt()->toBe($this->available_count));
