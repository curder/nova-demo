<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Auth\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'group' => $faker->word,
        'guard_name' => 'web',
    ];
});
