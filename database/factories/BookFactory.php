<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name,
            'description' => fake()->paragraph(10),
            'price' => fake()->numberBetween(700, 2500),
            'discount' => fake()->numberBetween(300, 1000),
            'quantity' => fake()->numberBetween(5, 50),
            'image_url' => null,
            'bestseller' => fake()->boolean,
            'bookshelf' => fake()->boolean,
        ];

    }


    public function randomImage($from , $to)
    {
        return $this->state(function (array $attributes) use ($from, $to){

            $num = rand($from, $to);

            if($num === 18 || $num === 2 ){
                return ["image_url" => 'books/book-'.$num.'.png',];
            }else{
                return ["image_url" => 'books/book-'.$num.'.jpg',];
            }

        });
    }

}
