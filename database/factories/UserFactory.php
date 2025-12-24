<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'phone' => fake()->phoneNumber,
            'address' => fake()->address,
            'age' => fake()->numberBetween(12, 65),
            'gender' => fake()->numberBetween(0, 1),
            'role' => 0,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


    public function randomGender()
    {
        return $this->state(function (array $attributes){

            return ["gender" => rand(0, 1)];

        });
    }

    public function randomAgeBetween(int $a1, int $a2)
    {
        return $this->state(function (array $attributes) use ($a1, $a2){

            return ["age" => rand($a1, $a2)];

        });
    }

}
