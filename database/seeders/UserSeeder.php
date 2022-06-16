<?php

namespace Database\Seeders;

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
            ->reject(fn($email) => User::query()->where('email', $email)->exists())
            ->each(
                fn($email) => User::factory()->create([
                    'name' => $email,
                    'email' => $email,
                    'password' => $default_password
                ])
            );
    }
}
