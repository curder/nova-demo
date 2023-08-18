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

        collect(Enums\UserEnum::cases())
            ->reject(fn (Enums\UserEnum $email) => Models\User::query()->where('email', $email->value)->exists())
            ->each(
                fn (Enums\UserEnum $email) => Models\User::query()->create([
                    'name' => $email->name,
                    'email' => $email->value,
                    'password' => $default_password,
                ])
            );
    }
}
