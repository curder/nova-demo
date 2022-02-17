<?php

namespace Tests\Integration\Console;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Curder\NovaPermission\Models\Permission;
use Curder\NovaPermission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * test db:seed command
 */
class DBSeedCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_see_some_init_data_in_tables(): void
    {
        $this->seed();

        $this->assertSame(2, User::query()->count());
        $this->assertSame(PermissionsEnum::count(), Permission::query()->count());
        $this->assertSame(RolesEnum::count(), Role::query()->count());
    }
}
