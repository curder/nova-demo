<?php

namespace Tests\Integration\Nova;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use NovaTesting\NovaAssertions;

/**
 * Class TestCase
 *
 * @package \Tests\Integration\Nova
 */
class TestCase extends \Tests\TestCase
{
    use LazilyRefreshDatabase;
    use NovaAssertions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function loginAdminUser(): User
    {
        $users = User::query()->get();
        $authed = $users->first();
        $this->be($authed);

        return $authed;
    }

    public function loginContentUser(): User
    {
        $users = User::query()
                     ->latest('id')
                     ->get();
        $authed = $users->first();
        $this->be($authed);

        return $authed;
    }
}
