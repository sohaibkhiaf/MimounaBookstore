<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fr_name' => fake()->city,
            'ar_name' => fake()->city,
            'enabled' => true,
            'stop_desk' => fake()->numberBetween(400, 600),
            'a_domicile' => fake()->numberBetween(550, 850),
        ];
    }
}
