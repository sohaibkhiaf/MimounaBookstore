<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review' => fake()->paragraph(5),
            'published' => false,
            'edited' => false,
        ];
    }

    public function randomLanguage()
    {
        return $this->state(function (array $attributes){

            if(rand(0, 1) == 0 ){
                return ["review" => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي.'];
            }else{
                return ["review" => 'Lorem ipsum odor amet, consectetuer adipiscing elit. Convallis nullam cursus elit; massa quisque aliquet eu euismod nisi.'];
            }

        });
    }

    public function randomPubStatus()
    {
        return $this->state(function (array $attributes){

            if(rand(0, 1) == 0 ){
                return ["published" => false];
            }else{
                return ["published" => true];
            }

        });
    }

    public function randomEditedStatus()
    {
        return $this->state(function (array $attributes){

            if(rand(0, 1) == 0 ){
                return ["edited" => false];
            }else{
                return ["edited" => true];
            }

        });
    }


}
