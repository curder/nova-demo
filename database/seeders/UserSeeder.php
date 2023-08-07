<?php

namespace Database\Seeders;

use App\Enums;
use App\Models;
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

        collect(Enums\Role::cases())->map(fn (Enums\Role $role) => $role->users())
            ->flatten()
            ->unique()
            ->values()
            ->reject(fn (Enums\User $email) => Models\User::query()->where('email', $email->value)->exists())
            ->each(
                fn (Enums\User $email) => Models\User::query()->create([
                    'name' => $email->name,
                    'email' => $email->value,
                    'password' => $default_password,
                ])
            );
    }
}
