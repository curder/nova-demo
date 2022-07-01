<?php

namespace Database\Seeders;

use App\Enums\UsersEnum;
use App\Models\User;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void
    {
        $default_password = Hash::make('password');

        collect(RolesEnum::getInstances())
            ->map(fn($role) => $role->users())
            ->flatten()
            ->unique()
            ->values()
            ->map(fn ($user_name) => UsersEnum::fromValue($user_name))
            ->reject(fn(UsersEnum $user_enum) => User::query()->where('email', $user_enum->description)->exists())
            ->each(
                fn(UsersEnum $user_enum) => User::query()->create([
                    'name' => $user_enum->value,
                    'email' => $user_enum->description,
                    'password' => $default_password
                ]));
    }
}
