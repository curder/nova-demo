<?php

use App\Enums;

it('has groups static method on permissionsEnum class', fn () => expect(Enums\User::permissions())
    ->toBeCollection()->toHaveCount(1));

it('has enum key value and label method for Curder', fn () => expect(Enums\User::Super)
    ->toBeInstanceOf(Enums\User::class)
    ->toBeEnum('Super', 'super@example.com', '超级管理员'));

it('has enum key value and label method for Mkt', fn () => expect(Enums\User::Example)
    ->toBeInstanceOf(Enums\User::class)
    ->toBeEnum('Example', 'example@example.com', '内容管理员'));
