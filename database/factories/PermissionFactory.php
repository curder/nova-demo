<?php
namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Curder\NovaPermission\Models\Permission;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class PermissionFactory
 *
 * @package Database\Factories
 */
class PermissionFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Permission::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        return [
            'name' => $this->faker->word,
            'group' => $this->faker->word,
            'guard_name' => 'web',
        ];
    }
}
