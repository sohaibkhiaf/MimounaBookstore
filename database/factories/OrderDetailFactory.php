<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_title' => fake()->sentence(3),
            'quantity' => fake()->numberBetween(1, 2),
            'unit_price' => fake()->numberBetween(700, 2500),
        ];
    }
}
