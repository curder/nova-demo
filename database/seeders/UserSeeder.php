<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Enums\UsersEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_password = Hash::make('password');

        collect(RolesEnum::cases())->map(fn (RolesEnum $role) => $role->users())
            ->flatten()
            ->unique()
            ->values()
            ->reject(fn (UsersEnum $email) => User::query()->where('email', $email->value)->exists())
            ->each(
                fn (UsersEnum $email) => User::query()->create([
                    'name' => $email->name,
                    'email' => $email->value,
                    'password' => $default_password,
                ])
            );
    }
}
