<?php

namespace Database\Seeders;

use App\Enums;
use App\Models;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UserHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取当前所有用户并遍历后赋予权限
        Enums\User::permissions()->each(
            fn (Collection $permissions, string $email) => Models\User::query()->where('email', $email)->first()->syncPermissions($permissions->pluck('value'))
        );
    }
}
