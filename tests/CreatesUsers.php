<?php

namespace Tests;

use App\Models\User;

trait CreatesUsers
{
    protected function loginAsEditor()
    {
        $users = User::query()->latest('id')->get();
        $authed = $users->first();

        $this->loginAs($authed);

        return $authed;
    }

    protected function loginAsAdmin(): User
    {
        $users = User::query()->first();
        $authed = $users->first();

        $this->loginAs($authed);

        return $authed;
    }

    protected function loginAs(User $user): void
    {
        $this->be($user);
    }
}
