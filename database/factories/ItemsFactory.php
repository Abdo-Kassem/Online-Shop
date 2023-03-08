<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Items>
 */
class ItemsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'details' => fake()->text(100),
            'image' => fake()->image(),
            'price' => fake()->numberBetween(10,1000),
            'item_number' => fake()->numberBetween(1,100),
            'seller_id' => '22222222222222',
            'shipping_cost' => fake()->numberBetween(10,100),
            'subcategory_id' => mt_rand(1,2)
        ];
    }
}
