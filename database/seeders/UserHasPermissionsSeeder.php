<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\UsersEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class UserHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 获取当前所有用户并遍历后赋予权限
        UsersEnum::permissions()->each(function (Collection $permissions, string $user_name_enum) {
                $user_instance = UsersEnum::fromValue($user_name_enum);


                return User::query()
                           ->where('email', $user_instance->description)
                           ->first()
                           ?->syncPermissions($permissions);
            }
        );
    }
}
