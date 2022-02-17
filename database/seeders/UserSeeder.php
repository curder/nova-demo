<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Curder\NovaPermission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        collect(RolesEnum::getValues())->map(fn($role) => RolesEnum::users($role))
                                       ->flatten()
                                       ->unique()
                                       ->values()
                                       ->reject(fn($email) => User::query()->where('email', $email)->exists())
                                       ->each(
                                           fn($email) => User::factory()->create([
                                               'name' => Str::ucfirst(explode('@', $email)[0]),
                                               'email' => $email,
                                               'password' => $default_password
                                           ])
            );
    }
}
