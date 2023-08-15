<?php

namespace Tests;

use App\Models\User;

trait CreatesUsers
{
    protected function loginAsEditor(): User
    {
        /** @var User $authed */
        $authed = User::query()->latest('id')->first();

        $this->actingAs($authed);

        return $authed;
    }

    protected function loginAsAdmin(): User
    {
        /** @var User $authed */
        $authed = User::query()->first();

        $this->actingAs($authed);

        return $authed;
    }
}
