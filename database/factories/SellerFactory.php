<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => '33333333333333',
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'image' => fake()->image(),
            'password' => Hash::make('A123456A'),
            'status' => mt_rand(0,1)
        ];
    }

}
