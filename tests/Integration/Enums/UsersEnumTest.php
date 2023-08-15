<?php

use App\Enums;

it('has groups static method on permissionsEnum class', fn () => expect(Enums\User::permissions())
    ->toHaveCount(1));

