<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Outl1ne\MenuBuilder\MenuItemTypes\MenuItemStaticURLType;
use Outl1ne\MenuBuilder\MenuItemTypes\MenuItemTextType;

class MenuItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MenuItem::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory()->create(),
            'name' => $this->faker->name,
            'locale' => 'zh-CN',
            'class' => $this->faker->randomElement([
                MenuItemTextType::class,
                MenuItemStaticURLType::class,
            ]),
            'value' => '/',
            'target' => $this->faker->randomElement(['_self', '_blank']),
            'data' => null,
            'parent_id' => null,
            'order' => 1,
            'enabled' => true,
        ];
    }
}
