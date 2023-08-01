<?php

namespace Database\Factories;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Curder\NovaPermission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class PermissionFactory
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
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'group' => $this->faker->word,
            'guard_name' => 'web',
        ];
    }
}
