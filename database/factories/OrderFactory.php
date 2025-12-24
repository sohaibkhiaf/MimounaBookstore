<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subtotal' => fake()->numberBetween(700, 8000),
            'shipping' => fake()->numberBetween(400, 850),
            'total' => fake()->numberBetween(1100, 10000),
            'shipping_region' => fake()->city,
            'shipping_address' => fake()->address,
            'shipping_type' => 'A Domicile',
            'shipping_name' => fake()->name,
            'shipping_phone' => fake()->phoneNumber,
        ];
    }

    public function randomShippingType()
    {
        return $this->state(function (array $attributes){

            $num = rand(0, 1);

            if(rand(0, 1) == 0 ){
                return ["shipping_type" => 'A Domicile'];
            }else{
                return ["shipping_type" => 'Pick-up Desk'];
            }

        });
    }
}
