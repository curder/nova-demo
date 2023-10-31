<?php

namespace Tests;

use App\Models\User;
use App\Enums\UserEnum;

trait CreatesUsers
{
    protected function loginAsEditor(): User
    {
        /** @var User $authed */
        $this->actingAs($authed = User::query()->where('email', UserEnum::Example->value)->first());

        return $authed;
    }

    protected function loginAsAdmin(): User
    {
        /** @var User $authed */
        $this->actingAs($authed = User::query()->where('email', UserEnum::Super->value)->first());

        return $authed;
    }
}
