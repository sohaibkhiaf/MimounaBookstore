<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'en_name' => fake()->sentence(2),
            'ar_name' => fake()->sentence(2),
            'fr_name' => fake()->sentence(2),
            'fa_icon' => 'fa-solid fa-book',
        ];
    }
}
